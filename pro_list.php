<?php 
error_reporting(0);

include("includes.php");
$uploadfolder="http://upload.gpsdirectory.net/videouplods/productvideos/thumb/";
@$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
@$fval = isset($_POST['fval']) ? $_POST['fval'] : $_GET['fval'];
switch($type){
    case "ajaxkeyword":
			$data["videokeyword"]["keyword"]=$_POST["keyword"];
			$data["videokeyword"]["type"]=$_POST["vtype"];
			$case=base64_encode(json_encode($data,true));
			$search=WEBSERVICE."&Case=$case";
			//echo $search;
			$json = file_get_contents($search);
        	$search_result = json_decode($json,true);
			//print_r($search_result);
			//$result= json_encode($search_result["Data"],true);
			//echo $result;
			//$result= json_decode($result,true);
			//print_r($result);
			$keyword='<ul id="country-list">';
			for($i=0;$i<count($search_result["Data"]);$i++){
				$keyword.='<li class="apppurchase" ';
				$keyword.= 'id="'.$search_result["Data"][$i]["title"].'" >';
				$keyword.= $search_result["Data"][$i]["title"].'</li>';
			}
			$keyword.='</ul>';
			echo $keyword;
break;
     default:
	 
	$data["CategoryDisplayList"]["type"]="Product Display";
	$data["CategoryDisplayList"]["page"]=isset($_POST["page"])?$_POST["page"]:1;
    $data["CategoryDisplayList"]["title"]=isset($_POST["title"])?$_POST["title"]:"";
	
	    $case=base64_encode(json_encode($data,true));
		$rlist=WEBSERVICE."&Case=$case";		
		$json = file_get_contents($rlist);
		$pro_list = json_decode($json,true); 
		//echo $rlist;
	   include "layouts/common/head.html";
	   include "layouts/default/pro_list.html";	
       include "layouts/common/footer.html";	 
    break;
}
?>