<?php 
error_reporting(0);

include("includes.php");
@$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
@$fval = isset($_POST['fval']) ? $_POST['fval'] : $_GET['fval'];
$uploadfolder="videouplods/";

switch($type){
	
	case "payment_log":
	
	$data["payment_log"]["type"]="5";
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
	
	case "taxcal":
	
		$data["planinfo"]["plan"]="Self Display";
		$case=base64_encode(json_encode($data,true));
		$rlist=WEBSERVICE."&Case=$case";
		
		$json = file_get_contents($rlist);
		$self_display = json_decode($json,true);
		
		$Taxinfo=$self_display["Taxinfo"];
		
		echo '<div class="form-group" style="text-align:center;font-weight:bold;font-size:15px;border-bottom:1px solid #fff;padding-bottom:10px;"> Payment Summary </div>';
		echo '<div class="form-group" ><div class="col-md-8" >Plan Amount</div><div class="col-md-4" ><i class="fa fa-inr" aria-hidden="true"></i> &nbsp;&nbsp;<span id="planamt">'.$_POST['planamount'].'</span><input type="hidden" name="amount" value="'.$_POST['planamount'].'"></div></div>';
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
		echo '<div class="form-group" ><div class="col-md-8" style="font-weight:bold;font-size:15px;">Total Amount</div><div class="col-md-4" style="font-weight:bold;font-size:15px;"><i class="fa fa-inr" aria-hidden="true"></i> &nbsp;&nbsp;<span id="netamount">'.$totalamount.'</span></div></div>';
		
		
		//echo "#@#";
		
		//echo $total+$_POST['planamount'];
		
		
	break;
    
	case "upload":
		
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
	
	 $taxdetails;
		
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$upload_exts = end(explode(".", $_FILES["uploadedfile"]["name"]));
		$file_name = $_FILES['uploadedfile']['name'];
		$file_size = $_FILES['uploadedfile']['size'];
		$file_type = $_FILES['uploadedfile']['type'];
		$temp_name = $_FILES['uploadedfile']['tmp_name'];
        $filename=time().".".$upload_exts;
        $file=current(explode(".", $filename));
        //echo $filename."-".$file;
        //exit();
        //move_uploaded_file($temp_name, $uploadfolder.$filename);
        $upload_exts = end(explode(".", $_FILES["uploadedfile"]["name"]));
    $file_name=time().".".$upload_exts;
	$dataimg = array(
                        'file' => new CURLFile($_FILES['uploadedfile']['tmp_name'],$_FILES['uploadedfile']['type'], $_FILES['uploadedfile']['name']),
                        'destination' => 'videouplods',
                        'calling_method' => 'upload_file',
                        'file_name' => $file_name
                    ); 
                    
                   echo videoupload_server($dataimg);
                   
	//	exec("ffmpeg -i /var/www/html/upload/videouplods/$filename -ss 00:00:02.000 -vf scale='1920:500' /var/www/html/upload/videouplods/thumb/$file.png");
		//$location = "videouplods/";
		
		
		$status=1;
		}else{
		$status=0;
		} 
		if($status==1){ 
		$data["upload_video_user"]["gpsid"]=$_POST["gpsid"];   
		$data["upload_video_user"]["video"]=$filename;
		$data["upload_video_user"]["description"]=$_POST["description"];
		$data["upload_video_user"]["ipaddress"]=$_SERVER['REMOTE_ADDR'];
        $data["upload_video_user"]["userid"]=$_SESSION["userid"];
		$data["upload_video_user"]["amount"]=$_POST["netamount"];
		$data["upload_video_user"]["taxdetails"]=$taxdetails;
        $data["upload_video_user"]["transactionid"]=$_POST["rzp_payment"];
        $data["upload_video_user"]["plan_amount"]=$_POST["amount"];
		$data["upload_video_user"]["plan"]=$_POST["plan"];
		$data["upload_video_user"]["plantype"]=$_POST["plantype"];
		$data["upload_video_user"]["location"]=$location;
		if(!empty($_POST["category"])){
			$data["upload_video_user"]["category"]=$_POST["category"];
		}
		if($_POST["plantype"]=="Competitor Video"){
			$data["upload_video_user"]["competitor"]=$competitor;
		}
		 
		/*$data["upload_video_user"]["video"]=$filename;
		$data["upload_video_user"]["description"]=$_POST["description"];
		$data["upload_video_user"]["ipaddress"]=$_SERVER['REMOTE_ADDR'];
        $data["upload_video_user"]["userid"]=$_SESSION["userid"];*/
		$case=base64_encode(json_encode($data,true));
		$rlist=WEBSERVICE."&Case=$case";
		
		$json = file_get_contents($rlist);
		$bobj1 = json_decode($json,true);
		header("Location:video_ad.php");
		}
		else{
			header("Location:post_video.php?msg=video not uploaded!");
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
			echo '<option value="'.$planinfo["PlanInfo"][$i]["fare_code"].'" planamount="'.$planinfo["PlanInfo"][$i]["amount"].'">'.$planinfo["PlanInfo"][$i]["fare_code"].' Views </option>';
		}
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
	
       default:	
	   	$plan["planinfo"]["plan"]="Home Video";
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
		include "layouts/default/post_video.html";   
        include "layouts/common/footer.html";	 
    break;
}
?>