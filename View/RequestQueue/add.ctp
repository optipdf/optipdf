<?php
echo $this->Form->create('Request',array(
    'type'=>'file'
));
echo $this->Form->input('file',array('type'=>'file'));
echo $this->Form->input('email');
echo $this->Form->end(__('Submit'));