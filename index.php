
<?php 
error_reporting(0);

include("includes.php");

@$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
@$fval = isset($_POST['fval']) ? $_POST['fval'] : $_GET['fval'];

switch($type){
	case "ajaxkeyword":
			$data["keyword"]["keyword"]=$_POST["keyword"];
			$data["keyword"]["city"]=$_POST["city"];
			$case=base64_encode(json_encode($data,true));
			$search=WEBSERVICE."&Case=$case";
           // echo $search;
			$json = file_get_contents($search);
        	$search_result = json_decode($json,true);
			$result= json_encode($search_result["keyword"],true);
			$result= json_decode($result,true);
			$keyword='<ul id="country-list">';
			for($i=0;$i<count($result);$i++){
				$keyword.='<li class="apppurchase" ';
				$keyword.= 'keyword="'.$result[$i]["keyword"].'"';
				$keyword.= 'keytype="'.$result[$i]["type"].'"';
				$keyword.= 'keyid="'.$result[$i]["id"].'" >';
				$keyword.= $result[$i]["keyword"].'</li>';
			}
			$keyword.='</ul>';
			echo $keyword;
break;
	 default:
	$data["gpscategory"]="";
			$case=base64_encode(json_encode($data,true));
			$search=WEBSERVICE."&Case=$case";
			
			$json = file_get_contents($search);
        	$search_result = json_decode($json,true);
			
			$json_result=json_encode($search_result);
		
        //echo $search;
		$db=new Database();
		$db->connect();
		$db->select(APPUSER,'count(*) as usercount',NULL,'','id desc');
		$res3 = $db->getResult();
	
		
		$db1=new Database();
		$db1->connect();

		$db1->select(LISTING,'count(*) as totcount',NULL,$cond,'id desc');
		$res = $db1->getResult(); 
		//print_r($db1);
		
		$cond="type=0 ";
		$db2=new Database();
		$db2->connect();
		$db2->select(LISTING,'count(*) as indcount',NULL,$cond,'id desc');
		$res1 = $db2->getResult();
        
        
		//print_r($db2);

		$cond1="type=1";
		$fdb=new Database();
		$fdb->connect();
		$fdb->select(LISTING,'count(*) as frmcount',NULL,$cond1,'id desc');
		$res2 = $fdb->getResult();	
		
		
			$categorydata["category_index"]="";
			$categorycase=base64_encode(json_encode($categorydata,true));
			 $categorysearch=WEBSERVICE."&Case=$categorycase";
			$categoryjson = file_get_contents($categorysearch);
        	$category_result = json_decode($categoryjson,true);
			//echo $categorysearch;
			
			$banner["banner_ads"]["plantype"]="Home Banner";
			$banner["banner_ads"]["location"]="Coimbatore";
			$bannercase=base64_encode(json_encode($banner,true));
			$bannersearch=WEBSERVICE."&Case=$bannercase";
            //echo $bannersearch;
			$bannerjson = file_get_contents($bannersearch);
        	$banner_result = json_decode($bannerjson,true);
			
			$location["Locations"]="";
			$locationcase=base64_encode(json_encode($location,true));
			$locationsearch=WEBSERVICE."&Case=$locationcase";
			//echo $locationsearch;
			$locationjson = file_get_contents($locationsearch);
        	$location_result = json_decode($locationjson,true);
			//print_r($location_result);
			
			
	   include "layouts/common/head.html";
	   include "layouts/default/index.html";	
       include "layouts/common/footer1.html";	 
    break;
}
?>