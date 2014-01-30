<div class="grid-container">
<div class="grid-100">
<?php
/**
* Page to display current job status
*/
echo $this->App->markdown('job_status',$job);
?>
</div>
<?php if($job['Job']['status_id']==3):?>
		    <div class="grid-50">
			<?php
			echo $this->Form->create('Job',array('url'=>array('controller'=>'jobs','action'=>'download')));
			echo $this->Form->input('id',array('value'=>$job['Job']['id']));
			echo $this->Form->input('email',array('label'=>__('Email'),'title'=>__('enter the email adress u used to upload the file.')));
			echo $this->Form->submit(__('Download'),array('class'=>'btn'));
			echo $this->Form->end();
			?>
			</div>
			<div class="grid-50">
			<?php
			echo $this->Form->create('Job',array('url'=>array('controller'=>'jobs','action'=>'download')));
			echo $this->Form->input('id',array('value'=>$job['Job']['id']));
			echo $this->Form->input('email',array('label'=>__('Email'),'title'=>__('enter the email adress u used to upload the file.')));
			echo $this->Form->submit(__('Force Remove'),array('class'=>'btn'));
			echo $this->Form->end();
			?>
			</div>
        <?php endif;?>
</div>
