<?php 
error_reporting(0);

include("includes.php");
@$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
@$fval = isset($_POST['fval']) ? $_POST['fval'] : $_GET['fval'];
switch($type){
	
	
	
	case "payment_log":
	
	$data["payment_log"]["type"]="0";
	$data["payment_log"]["payment_mode"]="Net Banking";
	$data["payment_log"]["fancy_id"]=$_POST["fancy_id"];
	$data["payment_log"]["gpsid"]=$_POST["gpsid"];
	$data["payment_log"]["Device"]="web";
	$data["payment_log"]["payment_status"]=$_POST["status"];
	$data["payment_log"]["user_id"]=$_SESSION["userid"];
	$data["payment_log"]["created_by"]=$_SESSION["userid"];
	$data["payment_log"]["created_ip"]=$_SERVER['REMOTE_ADDR'];

	
	$case=base64_encode(json_encode($data,true));
    $rlist1=WEBSERVICE."&Case=$case";
    $json = file_get_contents($rlist1);
	$razorpay = json_decode($json,true);
	
	echo $razorpay;
	
	break;
	
	case "payment_fancy":
	
	
	$data["payment_fancy"]["branch"]="1";
	$data["payment_fancy"]["payment_type"]="Net Banking";
	$data["payment_fancy"]["fancy_id"]=$_POST["fancy_id"];
	$data["payment_fancy"]["gpsid"]=$_POST["gpsid"];
	$data["payment_fancy"]["amount"]=$_POST["total"];
	$data["payment_fancy"]["ipaddress"]=$_SERVER['REMOTE_ADDR'];
	$data["payment_fancy"]["userid"]=$_SESSION["userid"];
	$data["payment_fancy"]["transactionid"]=$_POST["rzp_payment"];
	
	$case=base64_encode(json_encode($data,true));
    $rlist1=WEBSERVICE."&Case=$case";
    $json = file_get_contents($rlist1);
	$razorpay = json_decode($json,true);
	
	$code1=$razorpay["Response"][0]["response_code"];
		$msg1=$razorpay["Response"][0]["response_msg"];
		
		echo $code1;
		echo "#@#";
		echo $msg1;
	
	break;
	
	case "proceed_fancy":
	
	//print_r($_POST);
	$data["proceed_fancy"]["fancy_id"]=$_POST["fancy_id"];
	$case=base64_encode(json_encode($data,true));
    $rlist1=WEBSERVICE."&Case=$case";
    $json = file_get_contents($rlist1);
	$bobj1 = json_decode($json,true);
	//echo $rlist1;
	//exit;
	
        $fancyid=$bobj1["Response"][0]["fancyid"];
		$class=$bobj1["Response"][0]["class"];
		$amount=$bobj1["Response"][0]["amount"];
		$TotalAmount=$bobj1["Response"][0]["TotalAmount"];
		
		$taxamountarray=$bobj1["Response"][0]["tax"];
		
	
		
		
		echo $fancyid;
		echo "#@#";
		echo $class;
		echo "#@#";
		echo $amount;
		echo "#@#";
		echo $TotalAmount;
		
		echo "#@#";
		foreach ($taxamountarray as $key => $value) {
			echo ' <tr >
									  <td><b>'.$key.'</b></td>
									  <td>:</td>
									  <td><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;&nbsp;'.$value.'</td>
									</tr>';
}




	break;
	
	
	
	case "check_availability":
	//fval[fancy_id]
	//print_r($_POST);
	
		$data["fancy_availability"]["fancy_id"]=$_POST["fancy_id"];
		$data["fancy_availability"]["gpsid"]=$_POST["gpsid"];
		$data["fancy_availability"]["ipaddress"]=$_SERVER['REMOTE_ADDR'];
        $data["fancy_availability"]["userid"]=$_SESSION["userid"];
		$case=base64_encode(json_encode($data,true));
		$rlist=WEBSERVICE."&Case=$case";
		$json = file_get_contents($rlist);
		$bobj1 = json_decode($json,true);
		$code=$bobj1["Response"][0]["response_code"];
		$msg=$bobj1["Response"][0]["response_msg"];
		//echo $rlist;
		
		echo $code;
		echo "#@#";
		echo $msg;
		
	break;

	
     default:	
	 // print_r($_POST);
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
		include "layouts/default/fancyid_request.html";
	   }		   
        include "layouts/common/footer1.html";	 
    break;
}
?>