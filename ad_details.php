<?php 
error_reporting(0);

include("includes.php");
@$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
@$fval = isset($_POST['fval']) ? $_POST['fval'] : $_GET['fval'];
switch($type){
	
	case "addfavourite":
				$addfavourite["addfavourite"]["username"]=$_SESSION["userid"];
				$addfavourite["addfavourite"]["gpsid"]=$_POST["gpsid"];
	            $case=base64_encode(json_encode($addfavourite,true));				
				 $rlist=WEBSERVICE."&Case=$case";	
                $json = file_get_contents($rlist);
                $bobj = json_decode($json,true);
				echo $bobj["Response"]["0"]["response_msg"];
	
	break;
	case "removefavourite":
				$removefavourite["removefavourite"]["username"]=$_SESSION["userid"];
				$removefavourite["removefavourite"]["gpsid"]=$_POST["gpsid"];
	            $case=base64_encode(json_encode($removefavourite,true));				
				$rlist=WEBSERVICE."&Case=$case";
				//echo $rlist;
                $json = file_get_contents($rlist);
                $bobj = json_decode($json,true);
				echo $bobj["Response"]["0"]["response_msg"];
				//print_r($bobj);
	break;
	
	case "rating":
	
				$rate_us["rate_us"]["rating"]=$_POST["rating"];
				$rate_us["rate_us"]["comment"]=$_POST["comment"];
				$rate_us["rate_us"]["gpsid"]=$_POST["gpsid"];
				$rate_us["rate_us"]["devicetoken"]="web";
				$rate_us["rate_us"]["ipaddress"]=$_SERVER["REMOTE_ADDR"];
				$rate_us["rate_us"]["user_id"]=$_SESSION["userid"];
				
				$case=base64_encode(json_encode($rate_us,true));				
				$rlist=WEBSERVICE."&Case=$case";	
		
                $json = file_get_contents($rlist);
                $bobj = json_decode($json,true);
				//echo $bobj;
				//exit;		
                echo $bobj["Response"]["0"]["response_msg"];
				
	//print_r($_POST);
	break;
	
	case "feedback":
	
				$reviews["reviews"]["userid"]=$_SESSION["userid"];					
				$reviews["reviews"]["message"]=$_POST["message"];
				$reviews["reviews"]["email"]=$_SESSION["email_id"];
				$reviews["reviews"]["phone"]=$_SESSION["mobile_number"];
                $reviews["reviews"]["gpsid"]=$_POST["gpsid"];				
				$reviews["reviews"]["ipaddress"]=$_SERVER["REMOTE_ADDR"];
				$reviews["reviews"]["createby"]=$_SESSION["userid"];
				
	            $case=base64_encode(json_encode($reviews,true));	
				$rlist=WEBSERVICE."&Case=$case";						
                $json = file_get_contents($rlist);
                $bobj_message = json_decode($json,true);
				echo $bobj_message["Response"]["0"]["response_msg"];
				
	
	          
	break;
	
     default:
			$data["searchinfo"]["id"]=$_POST["id"];
			$data["searchinfo"]["type"]=$_POST["cattype"];
			$data["searchinfo"]["ipaddress"]=$_SERVER['REMOTE_ADDR'];
			$data["searchinfo"]["username"]=$_SESSION["userid"];
			$data["searchinfo"]["devicetoken"]='web';
			$data["searchinfo"]["option"]="View";
			$case=base64_encode(json_encode($data,true));
			$search=WEBSERVICE."&Case=$case";
			 //echo $search;
			$json = file_get_contents($search);
        	$search_result = json_decode($json,true);
			//echo "<pre>";
			//print_r($search_result);
			$ReviewList["ReviewList"]["gpsid"]=$_POST["gpsid"];	
			
			//$banner["competitor_banner"]["plantype"]="Competitor Banner";
			$banner["competitor_banner"]["location"]='Coimbatore';
			$banner["competitor_banner"]["gpsid"]=$search_result["Result"][0]["gpsid"];
			$bannercase=base64_encode(json_encode($banner,true));
			$bannersearch=WEBSERVICE."&Case=$bannercase";
			//echo $bannersearch;
			$bannerjson = file_get_contents($bannersearch);
        	$banner_result = json_decode($bannerjson,true);
			if(count($banner_result["BANNERS"]) >0){
      			$bannerstatus=1;
				$image=$banner_result["BANNERS"][0]["bannerimage"];
      		}else{
				$image="images/school_ad.png";
			}
		   include "layouts/common/head.html";
		   include "layouts/default/ad_details.html";	
		   include "layouts/common/footer1.html";	 
    break;
}
?>