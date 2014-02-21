<div class="grid-container">
    <?php echo $this->Session->flash();?>
    
    <div class="grid-30">
	<h2>Optimize Pdf</h2>
        <?php
        echo $this->Form->create('Job', array(
            'type' => 'file',
        ));
        echo $this->Form->input('email',array(
            'label'=>__('Email'),
            'title' => __('some text')//
        ));
        echo $this->Form->input('file',array(
                'type' => 'file',
                'label' => __('File'),
                'title' => __('Specify the pdf you want to optimize')
            )
        );
        echo $this->Form->input('author',array(
                'label'=>__('Author'),
                'title' => __('some text')//TODO
            )
        );
        echo $this->Form->input('title',array(
            'label'=>__('Title'),
            'title' => __('some text')//TODO
        ));
        echo $this->Form->input('language_id',array(
            'label'=>__('Document language'),
            'title' => __('some text')//TODO
        ));
        echo $this->Form->input('format_id',array(
            'label'=>__('Format'),
            'title' => __('some text')//TODO
        ));
        echo $this->Form->input('rotation_id',array(
            'label'=>__('Rotation'),
            'title' => __('some text')//TODO
        ));
        echo $this->Form->input('layout_id',array(
            'label'=>__('Layout'),
            'title' => __('some text')//TODO
        ));
        echo $this->Form->input('colormode_id',array(
            'label'=>__('Content'),
            'title' => __('some text')//TODO
        ));
        echo $this->Form->submit(__('Optimize'),array('class'=>'btn'));
        echo $this->Form->end();
        ?>
    </div>
    <div class="grid-70 mobile-grid-100">
        <?php echo $this->App->markdown('input_explanation');?>
    </div>
</div>
<div class="topbar"></div>
<?php $this->start('callback');?>
    $(document).ready(function() {
        var bar = $('.topbar');
        var options = {
            target: '#content',
            beforeSubmit: function() {
                var percentVal = '0%';
                bar.width(percentVal);
            },
            uploadProgress: function(event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                bar.width(percentVal);
            }
        };
        $('#JobAddJobForm').submit(function() {
            $(this).ajaxSubmit(options);
            return false;
        });
    });
<?php $this->end();?>
