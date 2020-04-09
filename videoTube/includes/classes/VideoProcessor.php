<?php

class VideoProcessor {

    private $con;
    private $sizeLimit = 500000000;
    private $ffmpeg = "ffmpeg/bin/ffmpeg.exe";
    // private $sizeLimit = 10000000000000;
    private $allowedTypes = array("mp4", "flv", "webm", "mkv", "vob", "ogv", "ogg", "avi", "wmv", "mov", "mpeg", "mpg");
    public function __construct($con)
    {
        $this->con = $con;
        // $this->ffmpeg = realpath("ffmpeg/bin/ffmpeg.exe");
    }

    public function upload($videoUploadData) {

        $targetDirectory = "uploads/videos/";
        $videoData = $videoUploadData->videoDataArray;

        $tempFilePath = $targetDirectory . uniqid() . basename($videoData['name']);
        $tempFilePath = str_replace(" ","_", $tempFilePath);

        $isValidData = $this->processData($videoData, $tempFilePath);

        if(!$isValidData) {
            return false;
        }
        if(move_uploaded_file($videoData["tmp_name"], $tempFilePath)) {
            // echo "File moved successfully";
            // return true;
            $finalFilePath = $targetDirectory . uniqid() . ".mp4";

            if(!$this->insertVideoData($videoUploadData, $finalFilePath)) {
                echo "Insert Query failed";
                return false;
            }
            if(!$this->convertVideoToMp4($tempFilePath, $finalFilePath)) {
                echo "Upload Falied\n";
                return false;
            }
        }
    
    }
    private function insertVideoData($uploadData, $filePath) {
        $query = $this->con->prepare("INSERT INTO videos(title, uploadedBy, description, privacy, category, filePath)
                                        VALUES(:title, :uploadedBy, :description, :privacy, :category, :filePath)");
        $query->bindParam(":title", $uploadData->title);
        $query->bindParam(":uploadedBy", $uploadData->uploadedBy);
        $query->bindParam(":description", $uploadData->description);
        $query->bindParam(":privacy", $uploadData->privacy);
        $query->bindParam(":category", $uploadData->category);
        $query->bindParam(":filePath", $filePath);

        return $query->execute();
    }

    public function convertVideoToMp4($tempFilePath, $finalFilePath) {
        $cmd = "$this->ffmpeg -i $tempFilePath $finalFilePath 2>&1";   // 2>&1 gives when error occurs
        $outputLog = array();
        exec($cmd, $outputLog, $returnCode);

        if($returnCode != 0) {
            
            foreach($outputLog as $line) {
                echo $line . "<br>";
                return false;
            }
            return false;
        }
        return true;

    }

    private function processData($videoData, $filePath) {
        $videoType = pathinfo($filePath, PATHINFO_EXTENSION);

        if(!$this->isValidSize($videoData)) {

            echo "File Too Large" . $this->sizeLimit . "bytes";
            return false;

        }

        else if(!$this->isValidType($videoType)) {

            echo "Invalid Filetype";
            return false;
        }
        else if($this->hasError($videoData))
        {
            echo "Error code" .$videoData["error"];
            return false;
        }
        return true;
    }

    private function hasError($data) {
        return $data['error'] != 0;
    }
    private function isValidType($type) {
        $lowercased = strtolower($type);

        return in_array($lowercased, $this->allowedTypes);
    }


    private function isValidSize($data) {
        return $data['size'] <= $this->sizeLimit;
    }

}
?>