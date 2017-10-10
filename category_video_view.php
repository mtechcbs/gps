<?php 
error_reporting(0);

include("includes.php");
@$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
@$fval = isset($_POST['fval']) ? $_POST['fval'] : $_GET['fval'];
//$uploadfolder="videouplods/".$_POST["path"]."/";
//print_r($_POST);
if($_POST["path"]!=""){
$uploadfolder="http://upload.gpsdirectory.net/videouplods/".$_POST["path"]."/";    
}else{
$uploadfolder="http://upload.gpsdirectory.net/videouplods/";
}
switch($type){
	
	
     default:	
	 			 $data["category_view_video"]["id"]=$_POST["id"];
				 $data["category_view_video"]["username"]=$_SESSION["userid"];
				 $data["category_view_video"]["ipaddress"]=$_SERVER['REMOTE_ADDR'];
				 $data["category_view_video"]["devicetoken"]="web";
				 $data["category_view_video"]["path"]=$_POST["path"];
				 $case=base64_encode(json_encode($data,true));
				 $news=WEBSERVICE."&Case=$case";
				 //echo $news;
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
	   include "layouts/common/head.html";
	   include "layouts/default/category_video_view.html";	
       include "layouts/common/footer.html";	 
    break;
}
?>