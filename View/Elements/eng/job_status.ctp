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
        	<?php echo $this->Html->link('Download',array('controller'=>'jobs','action'=>'download',$this->request->params['pass'][0],$this->request->params['pass'][1]));?>
                <?php echo $this->Html->link('Löschen',array('controller'=>'jobs','action'=>'remove',$this->request->params['pass'][0],$this->request->params['pass'][1]));?>
        <?php endif;?>
<?php endif;?>
