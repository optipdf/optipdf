<div class="grid-container">
    
<div class="grid-50 mobile-grid-100">
    	<?php
        echo $this->App->markdown('about_project');
    	?>
	<?php
        echo $this->App->markdown('about_techniques');
       ?>
</div>

<div class="grid-30 mobile-grid-100">
        <?php
        echo $this->App->markdown('about_jonas');
        ?>
	 <?php
        echo $this->App->markdown('about_lukas');
        ?>
</div>
    
</div>