<?php 
error_reporting(0);

include("includes.php");
//include("includes/session.php");
@$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
@$fval = isset($_POST['fval']) ? $_POST['fval'] : $_GET['fval'];
$uploadfolder="uploadfolder/bannerimages/";
//$thumb_folder="$uploadfolder/thumb/";
$file_exts = array("jpg", "bmp", "jpeg", "gif", "png");
switch($type){
	
	
	case "payment_log":
	
	$data["payment_log"]["type"]="4";
	$data["payment_log"]["payment_mode"]="Net Banking";
	
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
	case "taxcal":
	
		$data["planinfo"]["plan"]="Self Display";
		$case=base64_encode(json_encode($data,true));
		$rlist=WEBSERVICE."&Case=$case";
		
		$json = file_get_contents($rlist);
		$self_display = json_decode($json,true);
		
		$Taxinfo=$self_display["Taxinfo"];
		
		echo '<div class="form-group" style="text-align:center;font-weight:bold;font-size:15px;border-bottom:1px solid #fff;padding-bottom:10px;"> Payment Summary </div>';
		echo '<div class="form-group" ><div class="col-md-8" >Plan Amount</div><div class="col-md-4" ><i class="fa fa-inr" aria-hidden="true"></i> &nbsp;&nbsp;<span id="planamt">'.$_POST['planamount'].'</span></div></div>';
		if($_POST["locations"]==0){
		echo ' <div class="form-group"  > <div class="col-md-8">Location Amount</div><div class="col-md-4"><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;&nbsp;'.$_POST["locamount"].'</div> </div>';
		}
		if($_POST["locations"]==1){
			if($_POST["cntmetro"]>0){
		echo ' <div class="form-group" id="metro"  > <div class="col-md-8">Metro Cities (<span id="metrocnt">'.$_POST["cntmetro"].'</span>)</div><div class="col-md-4"><span id="metroamt"><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;&nbsp;'.$_POST["metroamt"].'</span></div> </div>';
			}
			if($_POST["cntnonmetro"]>0){
                echo ' <div class="form-group" id="nonmetro"  > <div class="col-md-8">Non Metro Cities  (<span id="nonmetrocnt">'.$_POST["cntnonmetro"].'</span>)</div><div class="col-md-4"><span id="nonmetroamt"><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;&nbsp;'.$_POST["nonmetroamt"].'</span></div> </div>';
			}
		}
         if($_POST["catcount"]>0){       
                  echo '<div class="form-group" id="catdetail"  > <div class="col-md-8">Category Fare </div><div class="col-md-4"><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;&nbsp;<span id="catdetailamt">'.$_POST["catamount"].'</span></div> </div>';}
		
		$total=0;
		

		for($k=0;$k<count($Taxinfo);$k++){
			
			if($Taxinfo[$k]['tax_amount']!=0)
			{
				$tax_amt=$Taxinfo[$k]['tax_amount'];
				
				$total+=$tax_amt;
			}else{
				$tax_amt=$Taxinfo[$k]['tax_percentage']*$_POST['planamount'];
				
				$total+=$tax_amt;
			}
			
			
			echo '<div class="form-group" ><div class="col-md-8" >'.$Taxinfo[$k]['tax_name'].'</div><div class="col-md-4" ><i class="fa fa-inr" aria-hidden="true"></i> &nbsp;&nbsp;'.$tax_amt.'</div></div>';
			
			
		}
		$totalamount=$total+$_POST['planamount']+$_POST["locamount"]+$_POST["catamount"];
		echo '<div class="form-group" ><div class="col-md-8" style="font-weight:bold;font-size:15px;">Total Amount</div><div class="col-md-4" style="font-weight:bold;font-size:14px;"><i class="fa fa-inr" aria-hidden="true"></i> &nbsp;&nbsp;<span id="netamount">'.$totalamount.'</span></div></div>';
		
		
		//echo "#@#";
		
		//echo $total+$_POST['planamount'];
		
		
	break;
	case "upload":
	
	//print_r($_POST);

	 for($i=0;$i<count($_POST["taxid"]);$i++){
        $taxinfo["Taxinfo"][$i]["id"]=$_POST["taxid"][$i];
        $taxinfo["Taxinfo"][$i]["name"]=$_POST["taxname"][$i];
        $taxinfo["Taxinfo"][$i]["percent"]=$_POST["taxpercent"][$i];
		if($taxinfo["Taxinfo"][$i]["id"]<>"164"){
        $taxinfo["Taxinfo"][$i]["amount"]=0;
		}else{
			$taxinfo["Taxinfo"][$i]["amount"]=$_POST["taxamount"][$i];
		}
    }
	if($_POST["display_type"]==1){
	$location=implode(",",$_POST["locations"]);
	if($_POST["metrocnt"]>0){
	$taxinfo["Taxinfo"][$i]["id"]="UT";
    $taxinfo["Taxinfo"][$i]["name"]="Metro Cities (".$_POST["metrocnt"].")";
	$taxinfo["Taxinfo"][$i]["percent"]=0;
	$taxinfo["Taxinfo"][$i]["amount"]=$_POST["metrocnt"]*$_POST["location_metro"];
	$i=$i+1;
	}
	if($_POST["nonmetrocnt"]>0){
	$taxinfo["Taxinfo"][$i]["id"]="UT";
    $taxinfo["Taxinfo"][$i]["name"]="Non Metro Cities (".$_POST["nonmetrocnt"].")";
	$taxinfo["Taxinfo"][$i]["percent"]=0;
	$taxinfo["Taxinfo"][$i]["amount"]=$_POST["nonmetrocnt"]*$_POST["location_nonmetro"];
	$i=$i+1;
	}
	}
	else{
	$location="All";
	$taxinfo["Taxinfo"][$i]["id"]="UT";
    $taxinfo["Taxinfo"][$i]["name"]="Location Fare";
	$taxinfo["Taxinfo"][$i]["percent"]=0;
	$taxinfo["Taxinfo"][$i]["amount"]=$_POST["location_amt"];
	$i=$i+1;
	}
	
	if(!empty($_POST["category"])){
	$taxinfo["Taxinfo"][$i]["id"]="UT";
    $taxinfo["Taxinfo"][$i]["name"]="Category Fare";
	$taxinfo["Taxinfo"][$i]["percent"]=0;
	$taxinfo["Taxinfo"][$i]["amount"]=$_POST["category_indamt"];
	}
	
	if($_POST["plantype"]=="Competitor Banner"){
	$competitor=implode(",",$_POST["competitor"]);	
	}
    $taxdetails = json_encode($taxinfo,true);
	
		
	$upload_exts = end(explode(".", $_FILES["uploadedfile"]["name"]));

        if($_FILES["uploadedfile"]["name"]<>""){
			
            if ((($_FILES["uploadedfile"]["type"] == "image/gif")|| ($_FILES["uploadedfile"]["type"] == "image/jpeg")|| ($_FILES["uploadedfile"]["type"] == "image/png")|| ($_FILES["uploadedfile"]["type"] == "image/pjpeg"))&& ($_FILES["uploadedfile"]["size"] < 2097152) && in_array($upload_exts, $file_exts))
              {
                    if ($_FILES["uploadedfile"]["error"] == 0) {
                        $filename=time().".".$upload_exts;
                    /*move_uploaded_file($_FILES["uploadedfile"]["tmp_name"],"$uploadfolder" . $filename);
                    //$fval["picture"]=$filename;
					
					$newname="$uploadfolder" . $filename;*/
					//$thumb_name="$thumb_folder"."thumb_".$filename;
					//echo $thumb_name;
					//make_banner_thumb($newname,$thumb_name,BANNER_WIDTH,BANNER_HEIGHT);
					 $dataimg = array(
                        'file' => new CURLFile($_FILES['uploadedfile']['tmp_name'],$_FILES['uploadedfile']['type'], $_FILES['uploadedfile']['name']),
                        'destination' => 'uploadfolder/bannerimages',
                        'calling_method' => 'upload_file',
                        'file_name' => $filename,
                        'bannertype'=>1
                    ); 
                    //print_r($dataimg);
                    fileupload_server($dataimg);
					
					
                   }
                   else{$filename="";}
              }
               else{$filename="";}
          }
           else{$filename="";}
		$data["upload_banner_user"]["gpsid"]=$_POST["gpsid"];   
		$data["upload_banner_user"]["bannerimage"]=$filename;
		$data["upload_banner_user"]["description"]=$_POST["description"];
		$data["upload_banner_user"]["ipaddress"]=$_SERVER['REMOTE_ADDR'];
        $data["upload_banner_user"]["userid"]=$_SESSION["userid"];
		$data["upload_banner_user"]["amount"]=$_POST["netamount"];
		$data["upload_banner_user"]["taxdetails"]=$taxdetails;
        $data["upload_banner_user"]["transactionid"]=$_POST["rzp_payment"];
        $data["upload_banner_user"]["plan_amount"]=$_POST["amount"];
		$data["upload_banner_user"]["plan"]=$_POST["plan"];
		$data["upload_banner_user"]["plantype"]=$_POST["plantype"];
		$data["upload_banner_user"]["location"]=$location;
		if(!empty($_POST["category"])){
			$data["upload_banner_user"]["category"]=$_POST["category"];
		}
		if($_POST["plantype"]=="Competitor Banner"){
			$data["upload_banner_user"]["competitor"]=$competitor;
		}
		$case=base64_encode(json_encode($data,true));
		$rlist=WEBSERVICE."&Case=$case";
		//echo $rlist;
		$json = file_get_contents($rlist);
		$bobj1 = json_decode($json,true);
		
       // print_r($bobj1);
        //exit();
		header("Location:banner_ad.php");
		   
	break;
	case "Add":
	
		$plan["planinfo"]["plan"]="Home Banner";
       	$case=base64_encode(json_encode($plan,true));
		$planlist=WEBSERVICE."&Case=$case";
		$planjson = file_get_contents($planlist);
		$planinfo = json_decode($planjson,true);
		
		$location["Locations"]="";
		$locationcase=base64_encode(json_encode($location,true));
		$locationsearch=WEBSERVICE."&Case=$locationcase";
		$locationjson = file_get_contents($locationsearch);
		$location_result = json_decode($locationjson,true);
		
		$data["mygpslist"]["email"]=$_SESSION["userid"];
		$data["mygpslist"]["mobile"]=$_SESSION["mobile_number"];
		$case=base64_encode(json_encode($data,true));
		$rlist=WEBSERVICE."&Case=$case";
		$json = file_get_contents($rlist);
		$gpsdata = json_decode($json,true);
		
		include "layouts/common/head.html";
		include "layouts/default/banner_ad.html";   
        include "layouts/common/footer.html";
	break;
	case "comp_banner":
		$plan["comp_banner"]["category"]=$_POST["category"];
       	$case=base64_encode(json_encode($plan,true));
		$complist=WEBSERVICE."&Case=$case";
		$compjson = file_get_contents($complist);
		$compinfo = json_decode($compjson,true);
		echo '<div style="text-align:left;"><label >Select Competitor</label><div>';
		for($i=0;$i<count($compinfo["Result"]);$i++){
			echo '<div style="text-align:left;"><label ><input  type="checkbox" name="competitor[]" value="'. $compinfo["Result"][$i]["gpsid"].'">&nbsp;'. $compinfo["Result"][$i]["name"].'</label></div>';
		}
	break;
	case "plandetails":
	
		$plan["planinfo"]["plan"]=$_POST["plan"];
       	$case=base64_encode(json_encode($plan,true));
		$planlist=WEBSERVICE."&Case=$case";
		$planjson = file_get_contents($planlist);
		$planinfo = json_decode($planjson,true);
		echo '<option value="">Select Plan</option>';
		for($i=0;$i<count($planinfo["PlanInfo"]);$i++){
		  if($planinfo["PlanInfo"][$i]["amount"]>0){
			echo '<option value="'.$planinfo["PlanInfo"][$i]["fare_code"].'" planamount="'.$planinfo["PlanInfo"][$i]["amount"].'">'.$planinfo["PlanInfo"][$i]["fare_code"].' Impression </option>';
		}}
	break;
	
       default:	
	 
	   	$data["userbanner_list"]["userid"]=$_SESSION["userid"];
		$case=base64_encode(json_encode($data,true));
		$rlist=WEBSERVICE."&Case=$case";
		$json = file_get_contents($rlist);
		$bobj1 = json_decode($json,true);
		
		
	
		
	    include "layouts/common/head.html";
		 if ($_GET["login"]=='0'){
	   include "layouts/default/gpsid_login.html";
	   }else{
		include "layouts/default/banner_ad_view.html"; 
	   }		
        include "layouts/common/footer.html";	 
    break;
}
?>