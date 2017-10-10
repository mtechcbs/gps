<?php
include("includes.php");
$path=$_GET["path"];
$userid=$_GET["userid"];

if($_SERVER['REQUEST_METHOD']=='POST'){
$file_name = $_FILES['uploadedfile']['name'];
$file_size = $_FILES['uploadedfile']['size'];
$file_type = $_FILES['uploadedfile']['type'];
$temp_name = $_FILES['uploadedfile']['tmp_name'];
$upload_exts = end(explode(".", $_FILES["uploadedfile"]["name"]));
$file_name=$userid."_".time().".".$upload_exts;
$location = "videouplods/$path";
/*echo $file_name;
exit();*/
//move_uploaded_file($temp_name, $location.$file_name);
//$file=current(explode(".", $file_name));

/*if($path=="selfvideos"){
exec("ffmpeg -i /var/www/vhosts/staging/gpsdirectory/videouplods/selfvideos/$file_name -ss 00:00:02.000 -vf scale='1920:500' /var/www/vhosts/staging/gpsdirectory/videouplods/selfvideos/thumb/$file.png");    
}elseif($path=="productvideos"){
exec("ffmpeg -i /var/www/vhosts/staging/gpsdirectory/videouplods/productvideos/$file_name -ss 00:00:02.000 -vf scale='1920:500' /var/www/vhosts/staging/gpsdirectory/videouplods/productvideos/thumb/$file.png");    
}*/

$dataimg = array(
                        'file' => new CURLFile($_FILES['uploadedfile']['tmp_name'],$_FILES['uploadedfile']['type'], $_FILES['uploadedfile']['name']),
                        'destination' => "$location",
                        'calling_method' => 'upload_file',
                        'file_name' => $file_name
                    ); 
                    
                    videoupload_server($dataimg);
                   

//exec("ffmpeg -i /var/www/vhosts/staging/gpsdirectory/videouplods/selfvideos/$file_name -ss 00:00:02.000 -vf scale='1920:500' /var/www/vhosts/staging/gpsdirectory/videouplods/selfvideos/thumb/$file.png");
echo $file_name;
}else{
echo "Error";
}
?>