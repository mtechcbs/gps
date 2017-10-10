<?php 
error_reporting(0);

include("includes.php");
@$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
@$fval = isset($_POST['fval']) ? $_POST['fval'] : $_GET['fval'];

switch($type){
	
	 case "register":
	 
	// print_r($_POST);
	 $data["register"]["email_id"]=$fval["email"];
	 $data["register"]["mobile_number"]=$fval["mobile"];
	 $data["register"]["first_name"]=$fval["first_name"];
	  $data["register"]["last_name"]=$fval["last_name"];
	 $data["register"]["gender"]=$fval["gender"];	
	 $data["register"]["dob"]=date("Y-m-d",strtotime($fval["dob"]));
	
	 
	 $case=base64_encode(json_encode($data,true));
	// echo $case;
	// exit();
	 $register=WEBSERVICE."&Case=$case";
	 $json = file_get_contents($register);
	 $bobj = json_decode($json,true);
     	 
 	
	  $code=$bobj["Response"][0]["response_code"];
	  $msg=$bobj["Response"][0]["response_msg"];
	  
	 
	 if($code==0){ //already register
		 header("Location:signup.php?msg=$msg");
	 }else{ //success
		 header("Location:login.php?msg=$msg");
	 }
	 	 
	 //echo $bobj["Response"]["0"]["response_code"]."`".$bobj["Response"]["0"]["response_msg"];
	 break;
	 
	 case "emailvalidation":
		$isAvailable = true;
		$table=APPUSER;

		$db->select("$table",'*',NULL,'email_id="'.$fval["email"].'"','id','1');
		$res = $db->getResult();
		//print_r($res);
		if(count($res)>0){
			$isAvailable = false;
		}else{
			$isAvailable = true;
		}

		// Finally, return a JSON
		echo json_encode(array(
			'valid' => $isAvailable,
		));
	 break;
	 
	 case "mobilevalidation":
		$isAvailable = true;
		$table=APPUSER;

		$db->select("$table",'*',NULL,'mobile_number="'.$_POST["mobile"].'"','id','1');
		$res = $db->getResult();
		//print_r($res);
		if(count($res)>0){
			$isAvailable = false;
		}else{
			$isAvailable = true;
		}

		// Finally, return a JSON
		echo json_encode(array(
			'valid' => $isAvailable,
		));
	 break;
	 
	 
	 
     default:
	 
	   include "layouts/common/head.html";
	   include "layouts/common/ajax_autocomplete.html";
	   include "layouts/default/signup.html";	
       include "layouts/common/footer1.html";	 
    break;
}
?>