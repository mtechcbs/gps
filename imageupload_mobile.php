<?php
include("includes.php");
//print_r($_POST);
//echo "<hr>";
//print_r($_FILES);

$dataimg = array(
				'file' => new CURLFile($_FILES['uploadedfile']['tmp_name'],$_FILES['uploadedfile']['type'], $_FILES['uploadedfile']['name']),
				'destination' => 'uploadfolder/bannerimages',
				'calling_method' => 'upload_file',
				'file_name' => basename( $_FILES['uploadedfile']['name']),
                'bannertype'=>1
		); 
        //$files = array('name'=>$_FILES['uploadedfile']['name'],"tmpname"=>$_FILES['uploadedfile']['tmp_name'],"type"=>$_FILES['uploadedfile']['type'],"size"=>$_FILES['uploadedfile']['size'],"error"=>$_FILES['uploadedfile']['error']);

/*print_r($dataimg);  
 $dataimg1["data"]=$dataimg;
 $dataimg1["files"]=$files;
 echo json_encode($dataimg1,true); */
                  
fileupload_server($dataimg);                
?>