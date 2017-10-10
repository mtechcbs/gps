<?php
include("includes.php");
/*header('Content-Type: image/jpg; charset=utf-8');
print_r($POST);
exit();
error_reporting(E_ALL);
if(isset($_POST['Image'])){
$imgname = $_POST['Image'];
$imsrc = str_replace(' ','+',$_POST['base64']);
$imsrc = base64_decode($imsrc);
$fp = fopen($imgname, 'w');
fwrite($fp, $imsrc);
if(fclose($fp)){
echo "Image uploaded";
}else{
echo "Error uploading image";
}
}*/
/*$file_path = "uploadfolder/";
     
    $file_path = $file_path . basename( $_FILES['image']['name']);
    if(move_uploaded_file($_FILES['image']['tmp_name'], $file_path)) {
        echo "success";
    } else{
        echo "fail";
    }*/
	
	
   // Where the file is going to be placed
   /*$target_path = "uploadfolder/userbanners/";
$thumb_folder="$target_path"."thumb/";
  // Add the original filename to our target path.
   //Result is "uploads/filename.extension" 
   echo "uploading started";
   $target_path = $target_path . basename( $_FILES['uploadedfile']['name']);

   if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
    $data = array(
                        'file' => new CURLFile($_FILES['uploadedfile']['tmp_name'],$_FILES['uploadedfile']['type'], $_FILES['uploadedfile']['name']),
                        'destination' => 'uploadfolder/bannerimages',
                        'calling_method' => 'upload_file',
                        'file_name' => basename( $_FILES['uploadedfile']['name'])
                    ); 
                    
                    fileupload_server($data);
	   $newname="$target_path" ;
	   //$thumb_name="$thumb_folder"."thumb_".basename( $_FILES['uploadedfile']['name']);
					$thumb_name="$thumb_folder".'thumb_'.basename( $_FILES['uploadedfile']['name']);
					echo "<br>".$newname."<br>".$thumb_name;
					$img=make_banner_thumb($newname,$thumb_name,BANNER_WIDTH,BANNER_HEIGHT);
					echo $img;
   echo "<br> The file ".  basename( $_FILES['uploadedfile']['name']).
   " has been uploaded";
   chmod ("$target_path".basename( $_FILES['uploadedfile']['name']), 0644);
   } else{
   echo "There was an error uploading the file, please try again!";
   echo "filename: " .  basename( $_FILES['uploadedfile']['name']);
   echo "target_path: " .$_FILES['uploadedfile']['name'];
   }
   */
   $dataimg = array(
				'file' => new CURLFile($_FILES['uploadedfile']['tmp_name'],$_FILES['uploadedfile']['type'], $_FILES['uploadedfile']['name']),
				'destination' => 'uploadfolder/bannerimages',
				'calling_method' => 'upload_file',
				'file_name' => basename( $_FILES['uploadedfile']['name'])
		); 
                    
fileupload_server($dataimg);
?>
