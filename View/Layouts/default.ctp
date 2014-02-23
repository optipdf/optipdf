<?php
/**
 *
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 */
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?> &raquo; Optipdf
	</title>
	<?php
		echo $this->Html->meta('icon','logo.ico');

		echo $this->Html->css('screen');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
    <link href='http://fonts.googleapis.com/css?family=Exo+2' rel='stylesheet' type='text/css'>
</head>
<body>
	<div id="container">
        <div id="header">
            <div  class="grid-container">
                <div class="logo">
                    <h1><?php echo $this->Html->link('Optipdf',array('controller'=>'pages','action'=>'display','index'));?></h1>
                </div>
                <nav id="mainnav">
                    <ul>
                        <li><?php echo $this->Html->link('Home',array('controller'=>'pages','action'=>'display','index'));?></li>
                        <li><?php echo $this->Html->link('Optimize',array('controller' => 'jobs', 'action' => 'addJob'));?></li>
                        <li><?php echo $this->Html->link('Blog','http://blog.optipdf.de');?></li>
                        <li><?php echo $this->Html->link('<i class="fa fa-github"></i>','https://github.com/optipdf/optipdf',array('escape'=>false,'class'=>'menuico','target'=>'_blank'));?></li>
                        <li><?php echo $this->Html->link('<i class="fa fa-facebook-square"></i>','https://www.facebook.com/optipdf',array('escape'=>false,'class'=>'menuico','target'=>'_blank'));?></li>
                    </ul>
                </nav>
            </div>
            <nav id="language_nav">
                <ul>
                    <li><?php echo $this->Html->link('English', array('language'=>'eng',isset($this->params['pass'][0])?$this->params['pass'][0]:null)); ?></li>
                    <li><?php echo $this->Html->link('Deutsch', array('language'=>'deu',isset($this->params['pass'][0])?$this->params['pass'][0]:null)); ?></li>
                </ul>
            </nav>
        </div>
		<div id="content">
			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
            <div class="grid-container">
                <p>
                    &copy; <?php echo $this->Html->link('Optipdf',array('controller'=>'pages','action'=>'display','impressum'));?> <?php echo date('Y');?>
                </p>
            </div>
		</div>
	</div>
<script type="text/javascript">
    function loadScripts(e,t){var n=function(e,t){var n=document.createElement("script");n.src=e;n.onload=n.onreadystatechange=function(){n.onreadystatechange=n.onload=null;t()};var r=document.getElementsByTagName("head")[0];(r||document.body).appendChild(n)};(function(){if(e.length!=0){n(e.shift(),arguments.callee)}else{t&&t()}})()}loadScripts(["http://code.jquery.com/jquery-1.10.1.min.js","http://optipdf.de/js/jquery.form.min.js"],function(){<?php echo $this->fetch('callback');?>})
</script>
</body>
</html>
