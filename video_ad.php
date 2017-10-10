<?php 
error_reporting(0);

include("includes.php");
@$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
@$fval = isset($_POST['fval']) ? $_POST['fval'] : $_GET['fval'];
$uploadfolder="http://upload.gpsdirectory.net/videouplods/thumb/";
//$thumb_folder="$uploadfolder/thumb/";
//$file_exts = array("jpg", "bmp", "jpeg", "gif", "png");
switch($type){
	
	
       default:	
	   	$data["uservideo_list"]["userid"]=$_SESSION["userid"];
		$case=base64_encode(json_encode($data,true));
		$rlist=WEBSERVICE."&Case=$case";
		//echo $rlist;
		$json = file_get_contents($rlist);
		$self_list = json_decode($json,true);
		
	    include "layouts/common/head.html";
		include "layouts/default/video_ad_list.html";   
        include "layouts/common/footer.html";	 
    break;
}
?>