<?php
/**
 * User: Lukas Strassel
 * Date: 02.12.13
 * Time: 22:47
 */

class RequestQueueController extends AppController{

    public $uses = array('Request');

    public function add(){
        if($this->request->is('post')){
            if($this->Request->save($this->request->data)){
                //TODO: start the magic
                debug($this->request->data);
            }else{
                //TODO: throw some validation error
            }
        }
    }

} 