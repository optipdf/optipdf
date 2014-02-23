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
        'Rotation'=>['option'=>'0'],
        'Layout'=>['option'=>'1'],
        'Colormode'=>['option'=>'black_and_white']//|color_grayscale|mixed
    ];

    public function __construct($options = array()){
        parent::__construct($options);
    }

    private $_path = null;

    public function process(){
        //Create folder for processing
        $this->_path = ROOT.DS.APP_DIR.DS.'tmp'.DS.'working'.DS.$this->options['Job']['id'].DS;
        $dir = new Folder($this->_path,true,0755);
        //copy file to folder and rotate if needed
        $qFile = new File(ROOT.DS.APP_DIR.DS.'tmp'.DS.'queue'.DS.$this->options['Job']['id']);
        //###############################################
        if($this->options['Rotation']['option']!='0'){
            $cmd = 'pdftk '.$qFile->pwd().' cat 1-'.$this->options['Rotation']['option'].' output '.$this->_path.$this->options['Job']['id'].'.pdf';
            $result = parent::_exec($cmd,'pdftk');
            if($result['stderr']){
                CakeLog::write('optishell', serialize($result));
                //TODO: got some error while rotation
            }
        }else{
            $qFile->copy($this->_path.$this->options['Job']['id'].'.pdf');
        }
        $qFile->close();
        //convert pdf to tif
        $cmd = 'gs -dNOPAUSE -dBATCH -sDEVICE=tiff24nc -r600 -o '.$this->_path.'gs-%04d.tif '.$this->_path.$this->options['Job']['id'].'.pdf';
        $result = parent::_exec($cmd,'ghostscript');
        if($result['stderr']){
            CakeLog::write('optishell', serialize($result));
            //TODO: got some error while ghostscript
            //but there are errors all the time, so take care
        }
        unlink($this->_path.$this->options['Job']['id'].'.pdf');
        //scantailor processing
        $scanDir = new Folder($this->_path.'scantailor'.DS,true,0755);
        $cmd = 'scantailor-cli -v --enable-page-detection --enable-fine-tuning --output-dpi=335 --alignment-vertical=top --alignment-horizontal=center --white-margins=true --normalize-illumination=true --tiff-compression=none --color-mode='.$this->options['Colormode']['option'].' --threshold=1 --layout='.$this->options['Layout']['option'].' --despeckle=normal '.$this->_path.'*.tif '.$scanDir->pwd();
        $result = parent::_exec($cmd,'scantailor-cli');
        CakeLog::write('optishell', serialize($result));
        $files = $dir->find('.*\.tif',true);
        parent::_cleanUp($dir->pwd(),$files);
        $files = $scanDir->find('.*\.tif',true);
        parent::_moveTo($scanDir->pwd(),$dir->pwd(),$files);
        $scanDir->delete();
        //tesseract tif to html
        $files = $dir->find('.*\.tif',true);
        foreach($files as $file){
            $file = new File($dir->pwd() . $file);
            $cmd = 'tesseract '.$dir->pwd().$file->name.' '.$this->_path.$file->name()." -psm 1 -l ".$this->options['Language']['option']." hocr";
            $result = parent::_exec($cmd,"tesseract");
            if($result['return']!=0){
                echo "some error inside tesseract";
                CakeLog::write('optishell', serialize($result));
            }
            $file->close();
        }
        $cmd = 'cd '.$this->_path.' && pdfbeads -d -P SinglePage -r 600 *.tif > '.$this->_path.$this->options['Job']['filename'];
        $result = parent::_exec($cmd,"pdftk");
        CakeLog::write('optishell', serialize($result));
        //exif info
        $options = '';
        if($this->options['Job']['title']!='')
            $options .= '-Title="'.$this->_path.$this->options['Job']['title'].'" ';
        if($this->options['Job']['author']!='')
            $options .= '-Author="'.$this->_path.$this->options['Job']['author'].'" ';
        if($options != ''){
            $cmd = 'exiftool -overwrite_original '.$options.'-Subject="optimzed by OptiPdf.de" '.$this->_path.$this->options['Job']['filename'];
            $result = $this->_exec($cmd,"exiftool");
            CakeLog::write('optishell', serialize($result));
        }
        //cleanup the mess
        $fdir = new Folder($this->_path.'../../finished/',true,0755);
        $file = new File($this->_path.$this->options['Job']['filename']);
        $file->copy($fdir->pwd().$this->options['Job']['id'].'_'.$this->options['Job']['filename']);
        $dir->delete();
        return;
    }

} 