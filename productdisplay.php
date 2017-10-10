<?php 
error_reporting(0);

include("includes.php");
//include("includes/session.php");
@$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
@$fval = isset($_POST['fval']) ? $_POST['fval'] : $_GET['fval'];
$uploadfolder="http://upload.gpsdirectory.net/videouplods/productvideos/thumb/";
switch($type){
	
	case "payment_log":
	
	$data["payment_log"]["type"]="2";
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
    case "taxcal":
	
		$data["planinfo"]["plan"]="Self Display";
		$case=base64_encode(json_encode($data,true));
		$rlist=WEBSERVICE."&Case=$case";
		
		$json = file_get_contents($rlist);
		$self_display = json_decode($json,true);
		
		$Taxinfo=$self_display["Taxinfo"];
		
		echo '<div class="form-group" style="text-align:center;font-weight:bold;font-size:15px;border-bottom:1px solid #fff;padding-bottom:10px;"> Payment Summary </div>';
		echo '<div class="form-group" ><div class="col-md-8" >Plan Amount</div><div class="col-md-4" ><i class="fa fa-inr" aria-hidden="true"></i> &nbsp;&nbsp;<span id="planamt">'.$_POST['planamount'].'</span></div></div>';
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
		$totalamount=$total+$_POST['planamount'];
		echo '<div class="form-group" ><div class="col-md-8" style="font-weight:bold;font-size:15px;">Total Amount</div><div class="col-md-4" style="font-weight:bold;font-size:15px;"><i class="fa fa-inr" aria-hidden="true"></i> &nbsp;&nbsp;<span id="netamount">'.$totalamount.'</span></div></div>';
	break;
	
	case "upload":
   
    
   /* $taxinfo["Taxinfo"][0]["id"]=0;
    $taxinfo["Taxinfo"][0]["name"]="Product Display Plan";
    $taxinfo["Taxinfo"][0]["percent"]="0";
    $taxinfo["Taxinfo"][0]["amount"]=$_POST["amount"];*/
    for($i=0;$i<count($_POST["taxid"]);$i++){
        $taxinfo["Taxinfo"][$i]["id"]=$_POST["taxid"][$i];
        $taxinfo["Taxinfo"][$i]["name"]=$_POST["taxname"][$i];
        $taxinfo["Taxinfo"][$i]["percent"]=$_POST["taxpercent"][$i];
        $taxinfo["Taxinfo"][$i]["amount"]=0;
    }
    $taxdetails = json_encode($taxinfo,true);
   
		if($_SERVER['REQUEST_METHOD']=='POST'){
		  $upload_exts = end(explode(".", $_FILES["uploadedfile"]["name"]));
		$file_name = $_FILES['uploadedfile']['name'];
		$file_size = $_FILES['uploadedfile']['size'];
		$file_type = $_FILES['uploadedfile']['type'];
		$temp_name = $_FILES['uploadedfile']['tmp_name'];
        //$file_name=time().".".$upload_exts;
        //$file=current(explode(".", $file_name));
		//move_uploaded_file($temp_name, $uploadfolder.$file_name);
        $upload_exts = end(explode(".", $_FILES["uploadedfile"]["name"]));
        $file_name=$_SESSION["userid"]."_".time().".".$upload_exts;
	$dataimg = array(
                        'file' => new CURLFile($_FILES['uploadedfile']['tmp_name'],$_FILES['uploadedfile']['type'], $_FILES['uploadedfile']['name']),
                        'destination' => 'videouplods/productvideos',
                        'calling_method' => 'upload_file',
                        'file_name' => $file_name
                    ); 
                    
                   echo videoupload_server($dataimg);
                   
		//exec("ffmpeg -i /var/www/vhosts/staging/gpsdirectory/videouplods/productvideos/$file_name -ss 00:00:02.000 -vf scale='1920:500' /var/www/vhosts/staging/gpsdirectory/videouplods/productvideos/thumb/$file.png");
		echo $file_name;
		}
		else{
		echo "Error";
		}
		$data["AddList"]["title"]=$_POST["title"];
        $data["AddList"]["gpsid"]=$_POST["gpsid"];
		$data["AddList"]["videourl"]=$file_name;
		$data["AddList"]["ipaddress"]=$_SERVER['REMOTE_ADDR'];
		$data["AddList"]["type"]="Product Display";
        $data["AddList"]["userid"]=$_SESSION["userid"];
        $data["AddList"]["taxdetails"]=$taxdetails;
        $data["AddList"]["amount"]=$_POST["netamount"];
        $data["AddList"]["transactionid"]=$_POST["rzp_payment"];
		$data["AddList"]["plan_amount"]=$_POST["amount"];
		$data["AddList"]["plan_duration"]=$_POST["plan"];
		$case=base64_encode(json_encode($data,true));
		$rlist=WEBSERVICE."&Case=$case";
		
		$json = file_get_contents($rlist);
		$bobj1 = json_decode($json,true);
		header("Location:productdisplay.php");
		   
	break;
       default:	
	   $data["DisplayList"]["type"]="Product Display";
        $data["DisplayList"]["userid"]=$_SESSION["userid"];
		$case=base64_encode(json_encode($data,true));
		$rlist=WEBSERVICE."&Case=$case";
		//echo $rlist;
		$json = file_get_contents($rlist);
		$bobj1 = json_decode($json,true);
		
		
		$plan["planinfo"]["plan"]="Product Display";
       	$case=base64_encode(json_encode($plan,true));
		$planlist=WEBSERVICE."&Case=$case";
		//echo $rlist;
		$planjson = file_get_contents($planlist);
		$planinfo = json_decode($planjson,true);
        
        $data1["mygpslist"]["email"]=$_SESSION["userid"];
		$data1["mygpslist"]["mobile"]=$_SESSION["mobile_number"];
		$case1=base64_encode(json_encode($data1,true));
		$rlist1=WEBSERVICE."&Case=$case1";
		
		$json1 = file_get_contents($rlist1);
		$gpsdata = json_decode($json1,true);
	    include "layouts/common/head.html";
         if ($_GET["login"]=='0'){
		include "layouts/default/gpsid_login.html";
	   }else{
		include "layouts/default/productdisplay.html";   
        }
        include "layouts/common/footer.html";	 
    break;
}
?>
