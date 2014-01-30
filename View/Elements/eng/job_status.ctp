<?php
/**
* Page to display current job status
* get cached every 120seconds, so <?php echo date( 'Y-m-d H:i:s', time());?> displays the timestamp of last refresh
* $job contains all relevant Job Data
*/
?>
//Scretch
Last time updated: <?php echo date( 'Y-m-d H:i:s', time());?>
File and email gets delted after 14days anyways,but u can force delete the file submitting this form.
You have to enter your email to access the download.
### Job info
Filename: <?php echo $job['Job']['filename'];?>
Last time processed <?php echo $job['Job']['modified'];?><br />
Job Status <?php echo $statuses[$job['Job']['status_id']];?><br />
