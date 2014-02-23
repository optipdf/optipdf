<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('GearmanQueue', 'Gearman.Client');
App::uses('PdfOptimizer','Lib/Optimizer');
/**
 * Jobs Controller
 *
 * @property Job $Job
 * @property PaginatorComponent $Paginator
 */
class JobsController extends AppController {

    /**
     * cronjob action which cleans up the jobs
     * removes files and deletes email out of database for all files older than 2 weeks
     */
    public function cleanup(){
        $jobs = $this->Job->find('list',array('fields'=>array('Job.filename'),'conditions'=>array('Job.created <='=>date( 'Y-m-d H:i:s', strtotime('-14 day', time())))));
        foreach($jobs as $key=>$filename){
            $this->Job->id = $key;
            unlink(ROOT.DS.APP_DIR.DS.'tmp'.DS.'queue'.DS.$key);
            unlink(ROOT.DS.APP_DIR.DS.'tmp'.DS.'finished'.DS.$key.'_'.$filename);
            $this->Job->save(array('status_id'=>4,'email'=>'removed@removed.de'));
        }
        return $this->redirect('/');
    }

    /**
     * totalFiles           :Count(Jobs)
     * totalSize            :SUM(Filesize)
     * averageProcessTime   :AVG(created -finished)
     * @return dataarray
     */
    public function statistics(){
        $statistics = $this->Job->find('first',array('fields'=>array('COUNT(Job.id) as totalFiles','SUM(Job.filesize) as totalSize','AVG(TIMESTAMPDIFF(SECOND, Job.created, Job.finished)) as averageProcessTime')));
        return $statistics;
    }


    /**
     * Components
     *
     * @var array
     */


    public function addJob(){
        if($this->request->is('post')){
            if($this->request->is('ajax')){
                $this->layout = 'ajax';
            }
            //get filesize filename ...
            if($this->Job->validates($this->request->data)){
                //transport the request to the jobworker
                if($this->Job->save($this->request->data)){
                    $this->Session->setFlash(__('The job has been saved.'));
                    $this->request->data['Job']['id'] = $this->Job->id;
                    $Email = new CakeEmail('smtp');
                    $Email->template('jobregistered', 'optipdf')
                        ->to($this->request->data['Job']['email'])
                        ->subject('File '.$this->request->data['Job']['file']['name'].' in queue.')
                        ->emailFormat('text')
                        ->viewVars(array('data' => $this->request->data['Job']));
                    try{
                        $Email->send();
                    }catch(Exception $e){
                        $this->Session->setFlash(__('Error while sending mail!'));
                        $this->Job->delete();
                        return $this->redirect('/optimize');
                    }
                    //move tmp file to the queue
                    $tmpfile = new File($this->request->data['Job']['file']['tmp_name']);
                    $tmpfile->copy(ROOT.DS.APP_DIR.DS.'tmp'.DS.'queue'.DS.$this->Job->id);
                    GearmanQueue::execute('init',$this->Job->id);
                    $this->redirect(array('action'=>'status',$this->Job->id));
                }else{
                    $this->Session->setFlash(__('The job could not be saved!'));
                }
            }else{
                $this->Session->setFlash(__('The job could not be saved ...!'));
            }
        }
        $rotations = $this->Job->Rotation->find('list',array('cache' => Configure::read('Config.language').'_rotationList','cacheConfig' => 'lists'));
        $statuses = $this->Job->Status->find('list',array('cache' => $this->Session->read('Config.language').'_statusList','cacheConfig' => 'lists'));
        $languages = $this->Job->Language->find('list',array('cache' => Configure::read('Config.language').'_languageList','cacheConfig' => 'lists'));
        $layouts = $this->Job->Layout->find('list',array('cache' => Configure::read('Config.language').'_layoutList','cacheConfig' => 'lists'));
        $colormodes = $this->Job->Colormode->find('list',array('cache' => Configure::read('Config.language').'_layoutList','cacheConfig' => 'lists'));
        $this->set(compact('statuses', 'languages','rotations','layouts','colormodes'));
    }


    public function download(){
        $job = $this->Job->find('first',array('conditions'=>array(
            'Job.id'=>$this->request->data['Job']['id'],
            'Job.email'=>$this->request->data['Job']['email'],
            'Job.status_id'=>3
        )));
        if(!empty($job)&&$job['Job']['status_id']!=4){
            $this->response->file(ROOT.DS.APP_DIR.DS.'tmp'.DS.'finished'.DS.$job['Job']['id'].'_'.$job['Job']['filename'],array('download' => true, 'name' => $job['Job']['filename']));
            return $this->response;
        }
        return $this->redirect(array('action'=>'status',$this->request->data['Job']['id']));
    }

    public function remove(){
        $job = $this->Job->find('first',array('conditions'=>array(
            'Job.id'=>$this->request->data['Job']['id'],
            'Job.email'=>$this->request->data['Job']['email'],
            'Job.status_id'=>3
        )));
        if(!empty($job)&&$job['Job']['status_id']!=4){
            $this->Job->id = $job['Job']['id'];
            unlink(ROOT.DS.APP_DIR.DS.'tmp'.DS.'queue'.DS.$job['Job']['id']);
            unlink(ROOT.DS.APP_DIR.DS.'tmp'.DS.'finished'.DS.$job['Job']['id'].'_'.$job['Job']['filename']);
            $this->Job->save(array('status_id'=>4,'email'=>'removed@removed.de'));
        }
        return $this->redirect('/optimize');
    }

    /**
     * displays current status
     * @param $id
     * @param $email
     */
    public function status($id = null){
        if (!$this->Job->exists($id)) {
            throw new NotFoundException(__('Invalid job'));
        }else{
            $job = $this->Job->find('first', array('conditions' => array('Job.id' => $id)));
            $statuses = $this->Job->Status->find('list',array('cache' => Configure::read('Config.language').'_statusList'));
        }
        if($this->request->is('ajax')){
            $this->layout = 'ajax';
        }
        $this->set(compact('job','statuses'));
    }
}
