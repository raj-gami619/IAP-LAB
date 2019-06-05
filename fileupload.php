<?php
/**
 * 
 */
class FileUploader
{
	private static $target_directory = "uploads/";
	private static $size_limit=50000;
	private $uploadOk = 1;
	private $file_original_name;
	private $file_type;
	private $file_size;
	private $final_file_name;

	public function setOriginalName($name){
		$this->file_original_name = $name;
	}
	public function getOriginalName(){
		return $this->file_original_name;
	}
	public function setFileType($type){
		$this->file_type=$type;
	}
	public function getFileType(){
		return $this->file_type;
	}
	public function setFileSize($size){
		$this->file_size=$size;
	}
	public function getFileSize(){
		return $this->file_size;
	}
	public function setFinalFileName($final_name){
		$this->final_file_name=$final_name;
	}
	public function getFinalFileName(){
		return $this->final_file_name;
	} 
	/*methods*/
	public function uploadFile(){
		$this->setOriginalName($_FILES['fileToUpload']['name']);
		$this->setFileType($_FILES['fileToUpload']['type']);
		$this->setFileSize($_FILES['fileToUpload']['size']);
		$this->saveFilePathTo();
		return $this->uploadOk;
	}
	public function fileAlreadyExists(){
		if (file_exists($this->getFinalFileName())) {
		    echo "Sorry, file already exists.";
		    $this->uploadOk = 0;
		    return $this->uploadOk;
		}
		$this->moveFile();
	}
	public function saveFilePathTo(){
		$t_dir=self::$target_directory;
		$target_file = $t_dir . basename($this->getOriginalName());
		$this->setFinalFileName($target_file);
		$this->fileWasSelected();
	}
	public function moveFile(){
		if ($this->uploadOk == 0) {
		    echo "Sorry, your file was not uploaded.";
		} else {
		    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $this->getFinalFileName())) {
		        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		        $this->uploadOk=1;
		        return $this->uploadOk;
		    } else {
		        echo "Sorry, there was an error uploading your file.";
		    }
		}
		return $this->uploadOk;
	}
	public function fileTypeIsCorrect(){
		$imageFileType = strtolower(pathinfo($this->getFinalFileName(),PATHINFO_EXTENSION));
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		    $this->uploadOk = 0;
		    return $this->uploadOk;
		}
		$this->fileSizeIsCorrect();
	}
	public function fileSizeIsCorrect(){
		if ( $this->getFileSize() > self::$size_limit) {
		    echo "Sorry, your file is too large.";
		    $this->uploadOk = 0;
		    return $this->uploadOk;
		}
		$this->fileAlreadyExists();
	}
	public function fileWasSelected(){
		if($_FILES['fileToUpload']['error'] == UPLOAD_ERR_NO_FILE) { 
		      echo "No file selected!";	
		      $this->uploadOk = 0;
		      return $this->uploadOk;
		}
		$this->fileTypeIsCorrect();
	}
}
?>