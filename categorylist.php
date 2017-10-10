<?php 
error_reporting(0);

include("includes.php");
@$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
@$fval = isset($_POST['fval']) ? $_POST['fval'] : $_GET['fval'];
switch($type){
	case "jsonresult":
			$data["gpscategory"]="";
			$case=base64_encode(json_encode($data,true));
			$search=WEBSERVICE."&Case=$case";
            			
			$json = file_get_contents($search);
            
			$search_result = json_decode($json,true);
			$json_result=json_encode($search_result["Result"]);
			echo $json_result;
	break;
     default:	
	
			$data["gpscategory"]="";
			$case=base64_encode(json_encode($data,true));
			$search=WEBSERVICE."&Case=$case";
			
			$json = file_get_contents($search);
        	$search_result = json_decode($json,true);
			
			$json_result=json_encode($search_result);
			//echo $json_result;
	   include "layouts/common/head.html";
	   include "layouts/default/categorylist.html";	
       include "layouts/common/footer.html";	 
    break;
}
?>