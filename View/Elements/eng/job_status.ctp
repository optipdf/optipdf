<?php
/**
* Page to display current job status
* get cached every 120seconds, so <?php echo date( 'Y-m-d H:i:s', time());?> displays the timestamp of last refresh
* $job contains all relevant Job Data
*/
?>
//Scretch
Last time updated: <?php echo date( 'Y-m-d H:i:s', time());?><br />
<?php
if(empty($job)):?>
	No valid entry
<?php else: ?>
	Last time processed <?php echo $job['Job']['modified'];?><br />
	Job Status <?php echo $statuses[$job['Job']['status_id']];?><br />
        <?php if($job['Job']['status_id']==3):?>
        	<div class="grid-container">
		    <?php if($job==null):?>
			No job found...
		    <?php else:?>
			### Job info
			Filename: <?php echo $job['Job']['filename'];?>
			You have to enter your email to access the download.
			<?php
			echo $this->Form->create('Job',array('url'=>array('controller'=>'jobs','action'=>'download')));
			echo $this->Form->input('id',array('value'=>$job['Job']['id']));
			echo $this->Form->input('email',array('label'=>__('Email'),'title'=>__('enter the email adress u used to upload the file.')));
			echo $this->Form->submit(__('Download'));
			echo $this->Form->end();
			?>
			File and email gets delted after 14days anyways,but u can force delete the file submitting this form.
			<?php
			echo $this->Form->create('Job',array('url'=>array('controller'=>'jobs','action'=>'download')));
			echo $this->Form->input('id',array('value'=>$job['Job']['id']));
			echo $this->Form->input('email',array('label'=>__('Email'),'title'=>__('enter the email adress u used to upload the file.')));
			echo $this->Form->submit(__('Force Remove'));
			echo $this->Form->end();
			?>
		    <?php endif;?>
		</div>
        <?php endif;?>
<?php endif;?>
