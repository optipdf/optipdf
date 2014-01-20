<?php
/**
 * Created by PhpStorm.
 * User: lukas
 * Date: 19.01.14
 * Time: 01:49
 */
App::uses('AbstractOptimizer','Lib/Optimizer');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class PdfOptimizer extends AbstractOptimizer{

    protected $options = [
        'Job'=>[
            'author'=>null,
            'title'=>null
        ],
        'Language'=>['option'=>'deu'],
        'Format'=>['option'=>'a5'],
        'Rotation'=>['option'=>null],
        'Layout'=>['option'=>1]

    ];

    public function __construct($options = array()){
        parent::__construct($options);
    }

    private $_path = null;

    public function process(){
        debug($this->options);
        //Create folder for processing
        $this->_path = ROOT.DS.APP_DIR.DS.'tmp'.DS.'working'.DS.$this->options['Job']['id'].DS;
        $dir = new Folder($this->_path,true,0755);
        //copy file to folder and rotate if needed
        $qFile = new File(ROOT.DS.APP_DIR.DS.'tmp'.DS.'queue'.DS.$this->options['Job']['id']);
        //###############################################
        $result = parent::_exec('pdfinfo '.$qFile->pwd(),'pdfinfo');
        if(isset($result['stdout'])&&!$result['stderr']){
            //do awesome math stuff
            debug($result['stdout']);
        }
        //rotation? format?...
        //###############################################
        if($this->options['Rotation']['option']!=null){//TODO:
            $cmd = 'pdftk '.$qFile->pwd().' cat 1-'.$this->options['Rotation']['option'].' output '.$this->_path.$this->options['Job']['id'].'.pdf';
            $result = parent::_exec($cmd,'pdftk');
            if($result['stderr']){
                debug($result);
                //TODO: got some error while rotation
            }
        }else{
            $qFile->copy($this->_path.$this->options['Job']['id'].'.pdf');
        }
        $qFile->close();
        //convert pdf to tif
        $cmd = 'gs -dNOPAUSE -dBATCH -sDEVICE=tiffg4 -r600 -o '.$this->_path.'gs-%04d.tif '.$this->_path.$this->options['Job']['id'].'.pdf';
        debug($cmd);
        $result = parent::_exec($cmd,'ghostscript');
        if($result['stderr']){
            debug($result);
            //TODO: got some error while ghostscript
            //but there are errors all the time, so take care
        }
        unlink($this->_path.$this->options['Job']['id'].'.pdf');
        //scantailor processing
        $scanDir = new Folder($this->_path.'scantailor'.DS,true,0755);
        $cmd = 'scantailor-cli -v --enable-page-detection --output-dpi=300 --enable-fine-tuning --margins-top=10 --default-margins-top=10 --content-detection=aggressive --alignment-vertical=top --alignment-horizontal=center --white-margins=true --normalize-illumination=true --threshold=1 --layout='.$this->options['Layout']['option'].' --despeckle=normal '.$this->_path.'*.tif '.$scanDir->pwd();
        parent::_exec($cmd,'scantailor-cli');
        $files = $dir->find('.*\.tif',true);
        parent::_cleanUp($dir->pwd(),$files);
        $files = $scanDir->find('.*\.tif',true);
        parent::_moveTo($scanDir->pwd(),$dir->pwd(),$files);
        $scanDir->delete();
        die();
        //tesseract tif to html
        $files = $dir->find('.*\.tif',true);
        foreach($files as $file){
            $file = new File($dir->pwd() . $file);
            $cmd = 'tesseract '.$dir->pwd().$file->name.' '.$this->_path.$file->name()." ".'$$--options--$$'." hocr";//TODO:
            parent::_exec($cmd,"tesseract");
            $file->close();
        }
        //hocr2pdf html to pdf
        $files = $dir->find('.*\.html',true);
        foreach($files as $file){
            $file = new File($dir->pwd() . DS . $file);
            $cmd = 'hocr2pdf -s -i '.$this->_path.$file->name().".tif -o ".$this->_path.$file->name().".pdf < ".$this->_path.$file->name;
            parent::_exec($cmd,"hocrtopdf");
            $file->close();
        }
        //combine pdfs
        $cmd = 'pdftk '.$this->_path.'*.pdf output '.$this->_path.'uncompressed-'.'$$--$filename--$$';//TODO:
        parent::_exec($cmd,"pdftk");
        $files = $dir->find('gs.*');
        parent::_cleanUp($dir->pwd());
        //compression
        $cmd = 'gs -dNOPAUSE -dBATCH -sDEVICE=pdfwrite -dPDFFitPage -sPAPERSIZE='.SIZEOPTION.' -dCompatibilityLevel=1.4 -dEmbedAllFonts=true -dSubsetFonts=true -sOutputFile='.$this->_path.__FILENAME__.' '.$this->_path.'*.pdf';
        $result = $this->_exec($cmd,"compress");
        //exif info


    }

} 