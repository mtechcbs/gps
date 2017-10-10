<?php 
error_reporting(0);

include("includes.php");
@$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
@$fval = isset($_POST['fval']) ? $_POST['fval'] : $_GET['fval'];
if($_POST["path"]!=""){
$uploadfolder="http://upload.gpsdirectory.net/videouplods/".$_POST["path"]."/";    
}else{
$uploadfolder="http://upload.gpsdirectory.net/videouplods/";
}
switch($type){
	
	
     default:	
	              $data["view_video_ads"]["id"]=$_GET["id"];
				 $data["view_video_ads"]["username"]=$_SESSION["userid"];
				 $data["view_video_ads"]["ipaddress"]=$_SERVER['REMOTE_ADDR'];
				 $data["view_video_ads"]["devicetoken"]="web";
				 $case=base64_encode(json_encode($data,true));
				 $news=WEBSERVICE."&Case=$case";
				// echo $news;
                 $json = file_get_contents($news);
		         $banner_info = json_decode($json,true);
				
				//print_r($banner_info);
				$gpsid=$banner_info["BANNERS"][0]["gpsid"];
				if(!empty($gpsid)){
					$status=1;
				$gpsdata["gpsinfo"]["gpsid"]=$gpsid;
				 $gpscase=base64_encode(json_encode($gpsdata,true));
				 $gpsinfo=WEBSERVICE."&Case=$gpscase";
                 $gpsjson = file_get_contents($gpsinfo);
		         $gps_info = json_decode($gpsjson,true);
				 //print_r($gps_info);
				}
	// print_r($_POST);
	   include "layouts/common/head.html";
	   include "layouts/default/video_view.html";	
       include "layouts/common/footer.html";	 
    break;
}
?>