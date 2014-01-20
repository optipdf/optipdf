<?php
/**
 * Created by PhpStorm.
 * User: lukas
 * Date: 19.01.14
 * Time: 02:06
 */
App::uses('File', 'Utility');
class AbstractOptimizer {

    protected $options = array();

    public function __construct($options){
        if ($options) {
            $this->options = Hash::merge($this->options, $options);
        }
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
            //TODO: better logging
        if($result['return']!='someawesome value'){
            //CakeLog::write('optimizer', $result);
        }
        return $result;
    }

    protected function _cleanUp($path,$files = array()){
        if(!empty($files)){
            foreach($files as $file){
                unlink($path.$file);
            }
        }
    }

    protected function _moveTo($from,$to,$files = array()){
        if(!empty($files)){
            foreach($files as $file){
                $file = new File($from . $file);
                $file->copy($to.$file->name);
                $file->close();
            }
        }
    }

} 