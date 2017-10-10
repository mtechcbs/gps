<?php 
error_reporting(0);

include("includes.php");
@$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
@$fval = isset($_POST['fval']) ? $_POST['fval'] : $_GET['fval'];
switch($type){
	
	
	
	
     default:	
	
	    $data["mygpsids"]["email"]=$_SESSION["userid"];
	  $data["mygpsids"]["mobile"]=$_SESSION["mobile_number"];

		$case=base64_encode(json_encode($data,true));
		$rlist=WEBSERVICE."&Case=$case";
		//echo $rlist;
		$json = file_get_contents($rlist);
		$bobj1 = json_decode($json,true);
       
	   include "layouts/common/head.html";
	   if ($_GET["type"]=='0'){
		include "layouts/default/gpsid_login.html";
	   }else{
		include "layouts/default/fancy_id.html";
	   }		   
        include "layouts/common/footer.html";	 
    break;
}
?>