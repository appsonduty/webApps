<?php 
require_once("includes/hearder.php");
require_once("includes/classes/VideoUploadData.php");
require_once("includes/classes/VideoProcessor.php");
// require_once("includes/classes/VideoDetailsFormProvider.php");

if(!isset($_POST["uploadButton"])) {
    echo "N0 fle sent to page";
    exit();
}

// 1) create file upload data
$videoUploadData = new VideoUploadData($_FILES["fileInput"], 
                                       $_POST["titleInput"], 
                                       $_POST["descriptionInput"], 
                                       $_POST["privacyInput"],
                                       $_POST["categoryInput"],
                                       "Replace_This"
                                    );

// 2) Process video data (upload)
$videoProcessor = new VideoProcessor($con);
$wasSuccessful = $videoProcessor->upload($videoUploadData);



// 3) Check if upload was successfull
?>
