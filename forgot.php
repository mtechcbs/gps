<?php 
error_reporting(0);

include("includes.php");
@$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
@$fval = isset($_POST['fval']) ? $_POST['fval'] : $_GET['fval'];
switch($type){
	case "Forgot":
		$fpass["forgot_password"]["user_name"]=$_POST["email"];
		$case=base64_encode(json_encode($fpass,true));
		$content=WEBSERVICE."&Case=$case";
		$json = file_get_contents($content);
		$obj1 = json_decode($json,true);
		$code=$obj1["Response"][0]["response_code"];
		$msg=$obj1["Response"][0]["response_msg"];
		if($code==1){
			$log=1;
		}else{
			$log=0;
		}
		header("Location:forgot.php?log=$log&msg=$msg"); 
	break;
	
     default:	
	   include "layouts/common/head.html";
	   include "layouts/default/forgot.html";	
       include "layouts/common/footer.html";	 
    break;
}
?>