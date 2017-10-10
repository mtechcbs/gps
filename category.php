<?php 
error_reporting(0);

include("includes.php");
@$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
@$fval = isset($_POST['fval']) ? $_POST['fval'] : $_GET['fval'];
switch($type){
	

     default:	
	 
  
		$keytype=isset($_POST["keyword"])?$_POST["keyword"]:$_GET["keyword"];
		 if($keytype==""){
		 header("Location:index.php");
	 }
	//Array ( [keyword] => bike service centers [keytype] => keyword [keyid] => 91 )
    $keyword=isset($_POST["keyword"])?$_POST["keyword"]:$_GET["keyword"];
			$data["keysearch"]["keyword"]=trim($keyword);
			$data["keysearch"]["id"]=isset($_POST["keyid"])?$_POST["keyid"]:$_GET["keyid"];//$_POST["keyid"];
			$data["keysearch"]["type"]=isset($_POST["keytype"])?$_POST["keytype"]:$_GET["keytype"];//$_POST["keytype"];
			$data["keysearch"]["ipaddress"]=$_SERVER['REMOTE_ADDR'];
			$data["keysearch"]["username"]=$_SESSION["userid"];
			$data["keysearch"]["devicetoken"]='web';
			$data["keysearch"]["page"]=isset($_POST["page"])?$_POST["page"]:1;
			$data["keysearch"]["location"]=$_POST["location"];
			$data["keysearch"]["lat"]=$_POST["lat"];
			$data["keysearch"]["long"]=$_POST["long"];
			if($_POST["column"]<>""){
				$data["keysearch"]["column"]=$_POST["column"];
			if($data["keysearch"]["column"]=="rating"){
			$data["keysearch"]["order"]="1";
			}else{
				$data["keysearch"]["order"]="0";
			}
			}else{
			$data["keysearch"]["column"]="";
			$data["keysearch"]["order"]="";
			}
			$case=base64_encode(json_encode($data,true));
			$search=WEBSERVICE."&Case=$case";
			//echo $search;
			$json = file_get_contents($search);
        	$search_result = json_decode($json,true);
			
			// sub Category Information
			$catid=$search_result["Result"][0]["catid"];
			$table=SUBCATEGORY;
		 	$cond="category='$catid' and status=0";
			$db->select("$table",'*',null,$cond,'id',null);
        	$result_set_cat = $db->getResult();
			
			
			$location["Locations"]="";
			$locationcase=base64_encode(json_encode($location,true));
			$locationsearch=WEBSERVICE."&Case=$locationcase";
			
			$locationjson = file_get_contents($locationsearch);
        	$location_result = json_decode($locationjson,true);
			
			//$banner["category_banner"]["plantype"]="Category Banner";
			$banner["category_banner"]["location"]=$_POST["location"];
			$banner["category_banner"]["category"]=$catid;
			$bannercase=base64_encode(json_encode($banner,true));
			$bannersearch=WEBSERVICE."&Case=$bannercase";
			$bannerjson = file_get_contents($bannersearch);
        	$banner_result = json_decode($bannerjson,true);
			if(count($banner_result["BANNERS"]) >0){
      			$bannerstatus=1;
      		}
			//echo $bannersearch;
	   include "layouts/common/head.html";
	   include "layouts/default/category.html";	
       include "layouts/common/footer.html";	 
    break;
}
?>