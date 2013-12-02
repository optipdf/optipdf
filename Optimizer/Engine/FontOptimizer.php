<?php
App::uses('AbstractOptimizer','CakeOptimizePdf.Optimizer/Engine');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
/**
 * Created by PhpStorm.
 * User: lukas
 * Date: 01.12.13
 * Time: 14:44
 */

class FontOptimizer extends AbstractOptimizer{


    protected $binary = "/usr/bin/tesseract";

    /**
     * Constructor
     *
     * @param $pdfPath path to pdf
     */
    public function __construct(CakeOptimizer $Optimizer) {
        parent::__construct($Optimizer);
    }

    /**
     * Implement in subclass to return raw pdf data.
     *
     */
    public function output(){
        $dir = $this->_Optimizer->tempDir();
        $files = $dir->find('.*\.tif', true);
        foreach($files as $file){
            $file = new File($dir->pwd() . DS . $file);
            $content = $this->_exec($this->_getCommand($file->name()),$this->_Optimizer->temp());
        }
        if (strpos(mb_strtolower($content['stderr']), 'error')) {
            throw new CakeException("System error <pre>" . $content['stderr'] . "</pre>");
        }
        if ((int)$content['return'] !== 0 && !empty($content['stderr'])) {
            throw new CakeException("Shell error, return code: " . (int)$content['return']);
        }

        return $content['stdout'];
    }


    protected function _exec($cmd,$input){
        $result = array('stdout' => '', 'stderr' => '', 'return' => '');

        $proc = proc_open($cmd,array(0 => array('pipe', 'r'), 1 => array('pipe', 'w'), 2 => array('pipe', 'w')),$pipes);
        fwrite($pipes[0], $input);
        fclose($pipes[0]);

        $result['stdout'] = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        $result['stderr'] = stream_get_contents($pipes[2]);
        fclose($pipes[2]);

        $result['return'] = proc_close($proc);

        return $result;
    }

    protected function _getCommand($filename) {
        $binary = $this->config('binary');

        if ($binary) {
            $this->binary = $binary;
        }
        if (!is_executable($this->binary)) {
            throw new CakeException(sprintf('scantailor binary is not found or not executable: %s', $this->binary));
        }
        return 'tesseract '.$this->_Optimizer->tempDir()->path.'/'.$filename.'.tif '.$this->_Optimizer->tempDir()->path.'/'.$filename.' -l deu hocr';/*.tif '.$this->_Optimizer->tempDir()->path;*/
    }

}