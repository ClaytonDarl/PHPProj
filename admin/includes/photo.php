<?php

class Photo extends DbObject{
    protected static $db_table = "photos";
    protected static $db_table_fields = ['title','caption','description','fileName', 'altText','fileType','size', 'author', 'likes', 'creationDate', 'private'];

    public $id;
    public $title;
    public $caption;
    public $description;
    public $fileName;
    public $altText;
    public $fileType;
    public $size;
    public $author;
    public $likes;
    public $creationDate;
    public $private;

    public $tmp_path;
    public $uploadDir = "images";
    public $errors = [];
    public $uploadErrorArray = array(
        UPLOAD_ERR_OK => "No error",
        UPLOAD_ERR_INI_SIZE => "Uploaded file exceeds the upload_max_filesize directive",
        UPLOAD_ERR_FORM_SIZE => "uploaded file exceeds the MAX_FILE_SIZE directive.",
        UPLOAD_ERR_PARTIAL => "Uploaded file was only partially uploaded",
        UPLOAD_ERR_NO_FILE => "No file was uploaded.",
        UPLOAD_ERR_NO_TMP_DIR => "Missing temp folder",
        UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk",
        UPLOAD_ERR_EXTENSION => "A php extension stopped the file upload"
    );

    //passing $_FILE['uploaded_file'] as an arg
    public function setFile($file) {

        if(empty($file) || !$file || !is_array($file)) {
            $this->errors[] = "There was no file uploaded here!";
            return false;
        } elseif ($file['error'] != 0) {
            $this->errors[] = $this->upload_error_array[$file['error']];
            return false;
        } else {
            $this->fileName = basename($file['name']);
            $this->tmp_path = $file['tmp_name'];
            $this->type = $file['type'];
            $this->size = $file['size'];
        }
    }

    public function saveFile() {
        if($this->id) {
            $this->update();
        } else {
            //if there is an error, dont create a file.
            if(!empty($this->errors)) {
                return false;
            }

            if(empty($this->fileName) || empty($this->tmp_path)) {
                $this->errors[] = "The file was not available!";
                return false;
            }
            //target upload pathway
            $targetPath = SITE_ROUTE . DS . 'admin' . DS . $this->uploadDir . DS . $this->fileName;

            //check if the file aready exists
            if(file_exists($targetPath)) {
                $this->errors[] = "The file {$this->fileName} already exists";
                return false;
            }


            if(move_uploaded_file($this->tmp_path, $targetPath)) {
                //success
                if($this->create()) {
                    unset($this->tmp_path);
                    return true;
                }
            } else {
                //failure
                $this->errors[] = "Most likely a permission mismatch! Please check if the upload directory is writeable!";
                return false;
            }
        }
    }

    public function deletePhoto() {
        if($this->delete()) {
            $targetPath = SITE_ROUTE . DS . 'admin' . DS . $this->picturePath();
            return unlink($targetPath) ? true : false;
        } else {
            return false;
        }
    }

    //Get the path to the picture
    public function picturePath() {
        return $this->uploadDir.DS.$this->fileName;
    }
}

?>
