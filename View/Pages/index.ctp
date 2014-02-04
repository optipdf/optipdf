<div class="grid-container">
    <div class="grid-50 mobile-grid-100">
    <?php
        echo $this->App->markdown('about_project');
    ?>
    </div>
    <div class="grid-50 mobile-grid-100">
        <?php
        echo $this->App->markdown('about_techniques');
        ?>
    </div>
    <div class="grid-33 mobile-grid-100">
        <?php
        echo $this->App->markdown('about_lukas');
        ?>
    </div>
    <div class="grid-33 mobile-grid-100">
        <?php
        echo $this->App->markdown('about_jonas');
        ?>
    </div>
    <div class="grid-33 mobile-grid-100">
        <?php
        echo $this->App->markdown('statistics');
        ?>
    </div>
</div>
