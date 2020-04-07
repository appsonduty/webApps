<?php 

class VideoDetailsFormProvider {

    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function createForm() {
        $fileInput = $this->createFileInput();
        $titleInput = $this->titleInput();
        $descriptionInput = $this->descriptionInput();
        $privacySelect = $this->createPrivacyInput();
        $categoriesInput = $this->createCategoriesInput();
        $createUploadButton = $this->createUploadButton();
        return "<form action='processing.php' method='POST'>
                $fileInput
                $titleInput
                $descriptionInput
                $privacySelect
                $categoriesInput
                $createUploadButton
        </form>";
    }

    private function createFileInput() {
        return "
        <div class='form-group'>
          
          <input type='file' class='form-control-file' id='formContolFile' name='fileInput' required>
        </div>
      ";
    }

    private function titleInput() {
        return "<div class='form-group'> 
        <input class='form-control' type='text' id='formControlInput' placeholder='Title' name='titleInput' required>
        </div>";
    }

    private function descriptionInput() {
        return "<div class='form-group'> 
        <textarea class='form-control' id='formControlTextarea' placeholder='Description' name='descriptionInput' rows='3'></textarea>
        </div>";
    }

    private function createPrivacyInput() {
        return "<div class='form-group'>
         
        <select class='form-control' id='formControlSelect' name='privacyInput'>
          <option value = '0'>Private</option>
          <option value = '1'>Public</option>
          
        </select>
      </div>";
    }

    private function createCategoriesInput() {
        $query = $this->con->prepare("SELECT * FROM categories");
        $query->execute();

        $html = "<div class='form-group'>
         
        <select class='form-control' id='formControlSelect' name='categoryInput'>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            // echo $row["name"] ."<br>";
            $html .= " <option value = '{$row['id']}'>{$row["name"]}</option>";
        }

        $html .= "</select>
        </div>";

        return $html;
    }

    private function createUploadButton () {
        return "<div class='form-group'>
        <button type='submit' class='btn btn-primary' name='uploadButton'>Upload</button>
        </div>";
    }


}

?>