<?php
/**
* UsAwe Theme by Lukas Strassel
* @author Lukas Strassel <lukasstrassel@googlemail.com>
* @link http://lukas-strassel.de
*/
?>
<!DOCTYPE html>
<html lang="de-DE">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="author" content="Lukas Strassel" />
    <title><?php echo $title_for_layout; ?> &raquo; <?php echo Configure::read('Site.title'); ?></title>
    <?php
    echo $this->Meta->meta();
    echo $this->Layout->feed();
    echo $this->Html->css('screen');
    ?>
    <link href='http://fonts.googleapis.com/css?family=Exo+2' rel='stylesheet' type='text/css'>
    <?php
    echo $this->Blocks->get('css');
    echo $this->Blocks->get('script');
    echo $scripts_for_layout;
    ?>
</head>
    <body>
        <div id="container">
            <div id="header">
                <div  class="grid-container">
                    <div class="logo">
                        <h1><?php echo $this->Html->link(Configure::read('Site.title'),'/'.$this->params['language']);?></h1>
                        <div id="tagline">
                            <p><?php echo Configure::read('Site.tagline'); ?></p>
                        </div>
                    </div>
                    <nav id="mainnav">
                        <ul>
                            <li><?php echo $this->Html->link('Home','http://optipdf.de');?></li>
                            <li><?php echo $this->Html->link('Optimize','http://optipdf.de/optimize');?></li>
                            <li><?php echo $this->Html->link('Blog','http://blog.optipdf.de');?></li>
                            <li><?php echo $this->Html->link('<i class="fa fa-github"></i>','https://github.com/sakulstra/optipdf',array('escape'=>false,'class'=>'menuico','target'=>'_blank'));?></li>
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

                <?php echo $this->Session->flash();?>

                <div class="grid-container">
                    <?php echo $this->fetch('content');?>
                </div>
            </div>
            <div id="footer">
                <div class="grid-container">
                    <p>
                        &copy; <?php echo $this->Html->link('Optipdf',array('language'=>$this->params['language'],'controller'=>'pages','action'=>'display','impressum'));?> <?php echo date('Y');?>
                    </p>
                </div>
            </div>
        </div>
        <?php //echo $this->element('sql_dump'); ?>
    </body>
</html>