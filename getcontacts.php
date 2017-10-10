<?php 
error_reporting(0);

include("includes.php");
@$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
@$fval = isset($_POST['fval']) ? $_POST['fval'] : $_GET['fval'];

switch($type){
	  
	  case "payment_log":
	 
	
	$data["payment_log"]["type"]="3";
	$data["payment_log"]["payment_mode"]="Net Banking";
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
	  
	  
	  case "Request_Contact":
   
/******** Tax details *********/
		$self["planinfo"]["plan"]="Get Contacts";
		$case1=base64_encode(json_encode($self,true));
		$rlist1=WEBSERVICE."&Case=$case1";
		$json1 = file_get_contents($rlist1);
		$getcontact1 = json_decode($json1,true);
		$Taxinfo=$getcontact1["Taxinfo"];
		/******** End Tax details *********/

	  for($i=0;$i<count($Taxinfo);$i++){
			$taxinfo1["Taxinfo"][$i]["id"]=$Taxinfo[$i]["tax_id"];
			$taxinfo1["Taxinfo"][$i]["name"]=$Taxinfo[$i]["tax_name"];
			$taxinfo1["Taxinfo"][$i]["percent"]=$Taxinfo[$i]["tax_percentage"];
			$taxinfo1["Taxinfo"][$i]["amount"]=$Taxinfo[$i]["tax_amount"];
		}
	
  /*   $taxdetails = json_encode($taxinfo1,true); */
	$amount_contact=explode('@',$_POST['Contact']);
	  $data["getcontact_request"]["userid"]=$_POST["userid"];
	  $data["getcontact_request"]["type"]=$_POST["type"];
	  $data["getcontact_request"]["gpsid"]=$_POST["gps"];
	  $data["getcontact_request"]["gpsid"]=$_POST["sms_cont"];
	  $data["getcontact_request"]["gpsid"]=$_POST["email_cont"];
	  $data["getcontact_request"]["contacts"]=$amount_contact[2];
	  $data["getcontact_request"]["contacts_amount"]=$amount_contact[0];
	  $data["getcontact_request"]["transactionid"]=$_POST["rzp_payment"];
	  $data["getcontact_request"]["total_amount"]=$_POST["netamount"];
	  $data["getcontact_request"]["taxdetails"]=$taxinfo1;
	  $data["getcontact_request"]["ipaddress"]=$_SERVER['REMOTE_ADDR'];
	  $data["getcontact_request"]["createby"]=$_SESSION["userid"];

	  
	   $case=base64_encode(json_encode($data,true));
	   echo $rlist=WEBSERVICE."&Case=$case";
		
		$json = file_get_contents($rlist);
		$getcontact = json_decode($json,true);
		$message=$getcontact["Response"][0]["response_msg"];
	  header("Location:gpslist.php?msg=$message");
	  break;
	  
	
	
	
	   case "tax_calc":
	
		$data["planinfo"]["plan"]="Get Contacts";
		$case=base64_encode(json_encode($data,true));
		$rlist=WEBSERVICE."&Case=$case";
		
		$json = file_get_contents($rlist);
		$getcontact = json_decode($json,true);
		
		$Taxinfo=$getcontact["Taxinfo"];
		
		
		
		$total=0;
		for($k=0;$k<count($Taxinfo);$k++){
			
			if($Taxinfo[$k]['tax_amount']!=0)
			{
				$tax_amt=$Taxinfo[$k]['tax_amount'];
				
				$total+=$tax_amt;
			}else{
				$tax_amt=$Taxinfo[$k]['tax_percentage']*$_POST['amt'];
				
				$total+=$tax_amt;
			}
			
			 
			echo '<div class="form-group" >
               <div class="col-md-6">'.$Taxinfo[$k]['tax_name'].'</div> 
               <div class="col-md-6">'.$tax_amt.'</div>
               </div>';
		}
		
		
		echo "#@#";
		
		echo $total+$_POST['amt'];
		
		echo "#@#";
		echo $_POST['amt'];
		
		
	break;	
       default:	
	//print_r($_POST);
	     $data["get_contacts"]["gpsid"]=$_POST["gpsid"];
	     $data["get_contacts"]["type"]=$_POST["type"];
		
		$case=base64_encode(json_encode($data,true));
		 $rlist=WEBSERVICE."&Case=$case";
		
		 $json = file_get_contents($rlist);
		 $bobj1 = json_decode($json,true);
		
	//	print_r($bobj1);
		
		
	    include "layouts/common/head.html";
		include "layouts/default/getcontacts.html";   
        include "layouts/common/footer.html";	 
    break;
}
?>