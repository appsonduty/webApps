<?php 
require_once("includes/hearder.php");
require_once("includes/classes/VideoDetailsFormProvider.php");

?>
            
    <div class="column">
        <?php
        $formProvider = new VideoDetailsFormProvider($con);
        echo $formProvider->createForm();

        

        ?> 
    </div>

<?php require_once("includes/footer.php")?>
                
            




