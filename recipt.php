<?php 
error_reporting(0);

include("includes.php");
@$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
@$fval = isset($_POST['fval']) ? $_POST['fval'] : $_GET['fval'];
switch($type){
     default:	
	  case "print_receipt_fancy":
	
	//print_r($_POST);
	$data["print_receipt_fancy"]["fancy_id"]=$_POST["fancyy_id"];
	$data["print_receipt_fancy"]["gpsid"]=$_POST["gpsid"];
	$data["print_receipt_fancy"]["email"]=$_POST["email"];
	
	$case=base64_encode(json_encode($data,true));
   $rlist1=WEBSERVICE."&Case=$case";
   echo $rlist1;
    $json = file_get_contents($rlist1);
	$bobj1 = json_decode($json,true);
	 
	 
	   include "layouts/common/head.html";
	   include "layouts/default/recipt.html";	
       include "layouts/common/footer.html";	 
    break;
}
?>