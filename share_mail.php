<?php 
error_reporting(0);

include("includes.php");
@$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
@$fval = isset($_POST['fval']) ? $_POST['fval'] : $_GET['fval'];
switch($type){  

	case "share":
	$code=0;
	$name=$fval["gpsname"];
	$lat=$fval["lat"];
	$long=$fval["long"];
	if($fval["sharetype"]=="sms"){
		$code=1;
		$response="Message Sent Successfully.";
		$mobile=$fval["mobile"];
        $msg="GPS Directory is the easiest way to find me! click to reach $name! http://maps.google.com/maps?q=$lat,$long";
        $message=urlencode($msg);
        $url="http://sms.hspsms.com/sendSMS?username=cmcmtech&message=$message&sendername=CMCGRP&smstype=TRANS&numbers=$mobile&apikey=7eb58010-10bc-4c2c-aed2-45e4ff33b7ec";
        $curl_handle=curl_init();
					  curl_setopt($curl_handle,CURLOPT_URL,$url);
					  curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
					  curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
					  $buffer = curl_exec($curl_handle);
					  curl_close($curl_handle);
       
	}elseif($fval["sharetype"]=="mail"){
		$code=1;
		$response="Mail Sent Successfully.";
		$path="http://data.gpsdirectory.net/emailtemplate/images/";
		$email_recipi=$fval["email"];
    	
		
		$content=file_get_contents("emailtemplate/sharegps.html");
		$content=str_replace("[0]",$email_recipi,$content);
		$content=str_replace("[1]",$name,$content);
		$content=str_replace("[lat]",$lat,$content);
		$content=str_replace("[long]",$long,$content);
		$content=str_replace("images/","$path",$content);
		//echo $content;
		
	   $subject = "GPS Directory Share Details";
	   $from = 'no-reply@gpsdirectory.net';
       $headers  = 'MIME-Version: 1.0' . "\r\n";
	   $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	   $headers .= 'From: '.$from."\r\n";
       mail($email_recipi, $subject, $content, $headers);
		//mail($to, $subject, $content, $headers);
	}else{
		$code=0;
		$response="No Option Selected.";
	}
	//header("Location:gpslist.php");
	 echo $code."#@#".$response;
     // mail($to, $subject, $content, $headers);  	
	  
	   
	break;
	
     default:
	 $type	= $_POST["type"];
	 //print_r($_POST);
			include "layouts/common/head.html";
			include "layouts/common/ajax_autocomplete.html";
			include "layouts/default/mail_share.html";	
			include "layouts/common/footer1.php";	 
    break;
}
?>