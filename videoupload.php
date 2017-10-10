<?php
include("includes.php");
if($_SERVER['REQUEST_METHOD']=='POST'){
$file_name = $_FILES['myFile']['name'];
$file_size = $_FILES['myFile']['size'];
$file_type = $_FILES['myFile']['type'];
$temp_name = $_FILES['myFile']['tmp_name'];
$userid=$_GET["userid"];
/*$location = "videouplods/";
$file=current(explode(".", $file_name));
move_uploaded_file($temp_name, $location.$file_name);
exec("ffmpeg -i /var/www/vhosts/staging/gpsdirectory/videouplods/$file_name -ss 00:00:01.000 -vframes 1 /var/www/vhosts/staging/gpsdirectory/videouplods/thumb/$file.png");
echo $file_name;
}else{
echo "Error";
}*/
$upload_exts = end(explode(".", $_FILES["myFile"]["name"]));
$file_name=$userid."_".time().".".$upload_exts;
$location = "videouplods/";
$dataimg = array(
                        'file' => new CURLFile($_FILES['myFile']['tmp_name'],$_FILES['myFile']['type'], $_FILES['myFile']['name']),
                        'destination' => "$location",
                        'calling_method' => 'upload_file',
                        'file_name' => $file_name
                    ); 
                    
                    videoupload_server($dataimg);
                    echo $file_name;
                    }

?>
	   