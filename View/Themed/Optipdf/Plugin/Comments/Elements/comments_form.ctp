<?php
$targetUrl = array(
    'plugin' => 'comments',
    'controller' => 'comments',
    'action' => 'add',
    $node['Node']['id'],
);
echo $this->Form->create('Comment', array('url' => $targetUrl));

echo $this->Form->input('Comment.name');

echo $this->Form->input('Comment.email');

echo $this->Form->input('Comment.website');

echo $this->Form->input('Comment.body');

if ($type['Type']['comment_captcha']) {
    echo $this->Recaptcha->display_form();
}

echo $this->Form->button(__('Submit'),array('type'=>'submit','class'=>'btn'));

echo $this->Form->end();