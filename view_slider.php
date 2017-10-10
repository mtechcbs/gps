<?php
error_reporting(0);
include("includes.php");




$username = $_POST['username'];
@$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];


        switch ($type) {  
		
        default:
				 $data["view_banner_ads"]["id"]=$_GET["id"];
				 $data["view_banner_ads"]["username"]=$_SESSION["gpsusername"];
				 $data["view_banner_ads"]["ipaddress"]=$_SERVER['REMOTE_ADDR'];
				 $data["view_banner_ads"]["devicetoken"]="web";
				 $case=base64_encode(json_encode($data,true));
				 $news=WEBSERVICE."&Case=$case";
                 $json = file_get_contents($news);
		         $banner_info = json_decode($json,true);
				
				//print_r($news);
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
				include "layouts/default/banner_ads.html";	
				include "layouts/common/footer.html";	 
		break;
        }


?>