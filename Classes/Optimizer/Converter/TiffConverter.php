<?php
/**
 * Created by PhpStorm.
 * User: lukas
 * Date: 01.12.13
 * Time: 23:53
 */
App::uses('AbstractConverter','CakeOptimizePdf.Optimizer/Converter');
App::uses('Folder', 'Utility');
class TiffConverter extends AbstractConverter{

    protected $binary = "/usr/bin/gs";
    /**
     * Implement in subclass to return raw pdf data.
     *
     */
    protected $_tempDir = null;


    public function convert(){
        //create temp folders
        $this->_Optimizer->tempDir(new Folder(TMP."temp_".$this->_Optimizer->filename(),true,0755));//replace test with hashedfilename
        //convert
        $content = $this->_exec($this->_getCommand(),$this->_Optimizer->temp());

        if (strpos(mb_strtolower($content['stderr']), 'error')) {
            throw new CakeException("System error <pre>" . $content['stderr'] . "</pre>");
        }

        if (mb_strlen($content['stdout'], $this->_Optimizer->encoding()) === 0) {
            throw new CakeException("Scantailor didn't return any data");
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

    protected function _getCommand() {
        $binary = $this->config('binary');

        if ($binary) {
            $this->binary = $binary;
        }
        if (!is_executable($this->binary)) {
            throw new CakeException(sprintf('gs binary is not found or not executable: %s', $this->binary));
        }
        //'gs -sDEVICE=tiffg4 -r600x600 -dNOPAUSE -dBATCH -dSAFER -sOutputFile=test_/test-%04d.tif test.pdf'
        return 'gs -sDEVICE=tiffg4 -r600x600 -dNOPAUSE -dBATCH -dSAFER -sOutputFile='.$this->_Optimizer->tempDir()->path.'/'.$this->_Optimizer->filename().'-%04d.tif '.TMP.$this->_Optimizer->filename().'.pdf';
    }

}