<?php 
error_reporting(0);

include("includes.php");
@$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
@$fval = isset($_POST['fval']) ? $_POST['fval'] : $_GET['fval'];
switch($type){
	
	case "update_profile":
	   		$data["my_profile_update"]["userid"]=$_SESSION["userid"];
	   		$data["my_profile_update"]["first_name"]=$_POST["first_name"];
	   		$data["my_profile_update"]["last_name"]=$_POST["last_name"];
	   		$data["my_profile_update"]["dob"]=date("Y-m-d",strtotime($_POST["dob"]));
	   		$data["my_profile_update"]["mobile_number"]=$_POST["mobile_number"];
	   		$data["my_profile_update"]["email_id"]=$_POST["email"];
			$case=base64_encode(json_encode($data,true));		
			$register=WEBSERVICE."&Case=$case";
			//echo $register;
		
			$json = file_get_contents($register);
			$bobj = json_decode($json,true);
			$code=$bobj["Response"][0]["response_code"];
			$msg=$bobj["Response"][0]["response_msg"];
			
		header("Location:profile.php?msg=$msg");
	break;
	/* case "change_password":
		//if($_POST["oldpassword"]===$_POST["password"]){

		$data["change_password"]["user_id"]=$_SESSION["userid"];
		$data["change_password"]["old_password"]=$_POST["oldpassword"];
		$data["change_password"]["new_password"]=$_POST["newpassword"];
		
		$case=base64_encode(json_encode($data,true));		
		$register=WEBSERVICE."&Case=$case";
		//echo $register;
		//exit();
		$json = file_get_contents($register);
		$bobj = json_decode($json,true);
		$code=$bobj["Response"][0]["response_code"];
		$msg=$bobj["Response"][0]["response_msg"];
		
		
		/*}else{
			$msg="Invalid Old Password";
		}
		header("Location:profile.php?msg=$msg");
    break;  */
     default:
	 
	 $data["view_profile"]["user_id"]=$_SESSION["userid"];
	 //$data["view_profile"]["last_name"]=$fval["last_name"];
	 
	$case=base64_encode(json_encode($data,true));
			$search=WEBSERVICE."&Case=$case";
			//echo $search;
			$json = file_get_contents($search);
        	$search_result = json_decode($json,true);

	
			//print_r($search_result);
	 
	   include "layouts/common/head.html";
	   include "layouts/common/ajax_autocomplete.html";
	   include "layouts/default/profile.html";	
       include "layouts/common/footer1.html";	 
    break;
}
?>