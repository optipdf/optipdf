<div class="grid-container">
    <h2>Optimize Pdf</h2>
    <div class="grid-33">
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
            'label'=>__('Colormode'),
            'title' => __('some text')//TODO
        ));
        echo $this->Form->submit(__('Optimize'));
        echo $this->Form->end();
        ?>
    </div>
    <div class="grid-66">
        <?php echo $this->App->markdown('input_explanation');?>
    </div>
</div>