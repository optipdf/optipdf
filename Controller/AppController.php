<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $components = array(
        'Cookie',
        'Session'
    );

    public $helpers = array(
        'Markdown.Markdown'
    );

    public function beforeFilter() {
        if(!isset($this->params['language'])){
            if($this->Cookie->read('lang'))
                $this->params['language']=$this->Cookie->read('lang');
            else
                $this->redirect(array('language'=>'eng'));
        }
        $this->_setLanguage();
    }

    protected function _setLanguage() {
        //if the cookie was previously set, and Config.language has not been set
        //write the Config.language with the value from the Cookie
        if ($this->Cookie->read('lang') && !$this->Session->check('Config.language')) {
            $this->Session->write('Config.language', $this->Cookie->read('lang'));
        }
        //if the user clicked the language URL
        else if ( isset($this->params['language']) &&
            ($this->params['language'] !=  $this->Session->read('Config.language'))
        ) {
            //then update the value in Session and the one in Cookie
            $this->Session->write('Config.language', $this->params['language']);
            $this->Cookie->write('lang', $this->params['language'], false, '20 days');
        }
        Configure::write('Config.language', $this->Session->read('Config.language'));
    }

    //override redirect
    public function redirect( $url, $status = NULL, $exit = true ) {
        if (!isset($url['language']) && $this->Session->check('Config.language')) {
            $url['language'] = $this->Session->read('Config.language');
        }
        parent::redirect($url,$status,$exit);
    }

}
