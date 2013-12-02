<?php
App::uses('AbstractOptimizer','CakeOptimizePdf.Optimizer/Engine');
/**
 * Class FormatOptimizer
 */
class FormatOptimizer extends AbstractOptimizer{

    /**
     * Path to the scantailor executable binary
     *
     * @access protected
     * @var string
     */
    protected $binary = "/usr/bin/scantailor-cli";

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
            throw new CakeException(sprintf('scantailor binary is not found or not executable: %s', $this->binary));
        }

        return 'scantailor-cli -v --enable-page-detection --content-detection=aggressive --normalize-illumination --dewarping=auto '.$this->_Optimizer->tempDir()->path.'/*.tif '.$this->_Optimizer->tempDir()->path;
    }


}