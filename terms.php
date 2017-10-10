<?php 
error_reporting(0);

include("includes.php");

switch($type){
	
	
     default:	
	 $data["cms"]["cms_type_id"]=4;
			$case=base64_encode(json_encode($data,true));
			$search=WEBSERVICE."&Case=$case";
			//echo $search;
			$json = file_get_contents($search);
        	$search_result = json_decode($json,true);	
			$content=$search_result["CMS"][0]["content"];
	   include "layouts/common/head.html";
	   include "layouts/default/terms.html";	
       include "layouts/common/footer.html";	 
    break;
}
?>