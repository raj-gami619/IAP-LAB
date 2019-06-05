<?php
class FileUploader{
	private $_supportedFormats = ['image/png','image/jpeg','image/jpg','image/gif'];
//	private static $target = "uploads/";

	public function uploadFile($file){
		if(is_array($file)){
			if(in_array($file['type'], $this->_supportedFormats)){
				if(move_uploaded_file($file['tmp_name'],'uploads/'.$file['name'])) {
					echo "File has been uploaded successfully";
				} else {
					echo "File has not been uploaded successfully";
						}
			}
			else{
				die('File is not supported');
			}
		}

//	public function fileAlreadyExists(){}
//	public function saveFilePathTo(){}
//	public function moveFile(){}
//	public function fileTypeIsCorrect(){}
//	public function fileSizeIsCorrect(){}
//	public function fileWasSelected(){}
}
}
?>