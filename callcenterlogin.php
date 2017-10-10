<?php 
error_reporting(0);

include("includes.php");


@$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
@$fval = isset($_POST['fval']) ? $_POST['fval'] : $_GET['fval'];

switch($type){
	case "login":
	//print_r($_POST);
	$data["login"]["user_name"]=$fval["email"];
	$data["login"]["password"]=$fval["password"];
	$case=base64_encode(json_encode($data,true));
	$rlist=WEBSERVICE."&Case=$case";
	//echo $rlist;
	//exit;
	$json = file_get_contents($rlist);
	$bobj1 = json_decode($json,true);

	//echo json_encode($bobj1,true);
	
	if($bobj1["Response"][0]["response_code"]==1){
		session_start();
		$_SESSION["gpsusername"]=$bobj1["Data"][0]["first_name"];
		$_SESSION["mobile_number"]=$bobj1["Data"][0]["mobile_number"];
		$_SESSION["email_id"]=$bobj1["Data"][0]["email_id"];
		$_SESSION["userid"]=$bobj1["Data"][0]["userid"];
		header("Location:create_firm.php");
	}else{
		header("Location:callcenterlogin.php?errmsg=1");
	}
	break;
     default:	
	   include "layouts/common/head.html";
	   include "layouts/common/ajax_autocomplete.html";
	   include "layouts/default/callcenterlogin.html";	
       include "layouts/common/footer.html";	 
    break;
}
?>