<div class="grid-container">
<?php
/**
* Page to display current job status
*/
echo $this->App->markdown('job_status',$job);
?>
<?php if($job['Job']['status_id']==3):?>
		    <?php if($job==null):?>
			No job found...
		    <?php else:?>
			<?php
			echo $this->Form->create('Job',array('url'=>array('controller'=>'jobs','action'=>'download')));
			echo $this->Form->input('id',array('value'=>$job['Job']['id']));
			echo $this->Form->input('email',array('label'=>__('Email'),'title'=>__('enter the email adress u used to upload the file.')));
			echo $this->Form->submit(__('Download'));
			echo $this->Form->end();
			?>
			<?php
			echo $this->Form->create('Job',array('url'=>array('controller'=>'jobs','action'=>'download')));
			echo $this->Form->input('id',array('value'=>$job['Job']['id']));
			echo $this->Form->input('email',array('label'=>__('Email'),'title'=>__('enter the email adress u used to upload the file.')));
			echo $this->Form->submit(__('Force Remove'));
			echo $this->Form->end();
			?>
		    <?php endif;?>
        <?php endif;?>
</div>
