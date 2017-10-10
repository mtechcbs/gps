<?php

/**
 * @author Anbazhagan.K
 * @copyright 2015
 */
include("includes.php");



@$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
@$fval = isset($_POST['fval']) ? $_POST['fval'] : $_GET['fval'];
$uploadfolder="../videouplods/selfvideos/";
$file_exts = array("mp4");

switch($type){
	case "payment_log":
		
		
		$data1["payment_log"]["user_id"]=$_POST["userid"];
		$data1["payment_log"]["type"]="3";
		$data1["payment_log"]["created_ip"]=$_SERVER['REMOTE_ADDR'];
		$data1["payment_log"]["payment_mode"]=$fval["optradio"];
		$data1["payment_log"]["payment_status"]=$_GET['status'];
		$data1["payment_log"]["Device"]="Admin Panel";
		$data1["payment_log"]["created_by"]=$_SESSION["emp_id"];
		
		
		$case1=base64_encode(json_encode($data1,true));
		$rlist1=WEBSERVICE."&Case=$case1";
		
		
		$json1 = file_get_contents($rlist1);
		$payment1 = json_decode($json1,true);
		
		$response_code1=$payment1["Response"][0]["response_code"];
		$response_msg1=$payment1["Response"][0]["response_msg"];
		
		echo $response_code1;
		echo "#@#";
		echo $response_msg1;
		
		
	break;
    case "Create":
		error_reporting(E_ALL);
		
		$data["planinfo"]["plan"]="Get Contacts";
		
		
		$case=base64_encode(json_encode($data,true));
		$rlist=WEBSERVICE."&Case=$case";
		
		$json = file_get_contents($rlist);
		$getcontact = json_decode($json,true);
		
		$PlanInfo=$getcontact["PlanInfo"];
		$Taxinfo=$getcontact["Taxinfo"];
		
		
		include "layouts/common/form_header.html";
        include "layouts/common/side_bar.html";
		include "layouts/common/autocomplete_userdetails.html";
        include "layouts/forms/getcontact.html";
        include "layouts/common/form_footer.html";
		
		
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
				$tax_amt=$Taxinfo[$k]['tax_percentage']*$_GET['amt'];
				
				$total+=$tax_amt;
			}
			
			
			echo '<tr>
			  <td><b>'.$Taxinfo[$k]['tax_name'].'</b></td>
			  <td>:</td>
			  <td><i class="fa fa-inr" aria-hidden="true"></i>&nbsp;&nbsp;'.$tax_amt.'</td>
			</tr>';
		}
		
		
		echo "#@#";
		
		echo $total+$_GET['amt'];
		
		
	break;	
	case "Ajax":		
		$db2 = new Database();
        $db2->connect();
		$db2->select(LISTING,'*',NULL,'type=1 and (gpsid LIKE "%'.strtoupper($_POST["keyword"]).'%"  or name LIKE "%'.$_POST["keyword"].'%")','id','');
		
		$reslisting = $db2->getResult();
		?>
		<style>
			.frmSearch {border: 1px solid #F0F0F0;background-color:#C8EEFD;margin: 2px 0px;padding:40px;}
			#country-list{float:left;list-style:none;margin:0;padding:0;width:100%;}
			#country-list li{padding: 10px; background:#FAFAFA;border-bottom:#F0F0F0 1px solid;}
			#country-list li:hover{background:#F0F0F0;}
			#search-box{padding: 10px;border: #F0F0F0 1px solid;}
		</style>
		<ul id="country-list" class="col-md-4" style="cursor:pointer;list-style:none;">		
			
		
		<?php	
			foreach($reslisting as $gpslisting) {
			$usernamesss=$gpslisting["name"]." | ".$gpslisting["gpsid"];
			$listingdet=$gpslisting["gpsid"]."|".$gpslisting["name"]."|".$gpslisting["mobile"]."|".$gpslisting["email"]."|".$gpslisting["fancyid"];
		?>
		<li onClick="selectlisting('<?php echo $listingdet;?>');"><?php echo $usernamesss; ?></li>
		<?php }?>
		</ul>
		
		<script>
		/* function selectlisting(val) { 
			
			var sal=val.split('|');
			alert(sal);
			$(".gpsdetails").val(sal[0]);
            $(".email_id").val(sal[3]);				
            $(".mobile_no").val(sal[2]);
			$(".continue1").show();			
			$("#suggesstion-box-name").hide();
			
		} */
	 function selectlisting(val) { 
			   if(val!=''){
				var sal=val.split('|');
				$(".gpsdetails").val(sal[0]);	
				var gpsid=sal[0];
				var seachcnt=$("#request_type option:selected").val();
				
				$.ajax({
					type: "POST",				
					url: "getcontact.php?type=getmycontact",
					data:'gpsid='+gpsid+'&types='+seachcnt,
					success: function(data){
						
						var saldata=data.split('|');
						$(".userid").val(saldata[0]);				
						$(".total_visitors").val(saldata[1]);				
						$(".dnd_visitors").val(saldata[2]);
						$(".purchased_contacts").val(saldata[3]);
						$(".remaining_contacts").val(saldata[4]);
						$(".email_id").val(saldata[5]);				
						$(".mobile_no").val(saldata[6]);
						$(".gpsname").val(saldata[7]);
						if(saldata[4]>0){
						$(".continue1").show();	
						}else{
							$(".continuemsg").show();
						}
						$("#suggesstion-box-name").hide();
						$("#suggesstion-box-name").html(data);			
					}
				});
			}else{		
				$("#suggesstion-box-name").hide();				
			}

		} 
		</script>
		
			<?php
	break;
	case "getmycontact":
		
	    $self["get_contacts"]["gpsid"]=$_POST["gpsid"];
	    $self["get_contacts"]["type"]=$_POST["types"];
		$case1=base64_encode(json_encode($self,true));
		$rlist1=WEBSERVICE."&Case=$case1";
		
		
		$json1 = file_get_contents($rlist1);
		$getcontact1 = json_decode($json1,true);	
		
		
		$userid=$getcontact1["Data"]["userid"];
		$total_visitors=$getcontact1["Data"]["total_visitors"];
		$dnd_visitors=$getcontact1["Data"]["dnd_visitors"];
		$email_id=$getcontact1["Data"]["email_id"];
		$mobile_no=$getcontact1["Data"]["mobile_no"];
		$gpsname=$getcontact1["Data"]["gps_name"];
		$purchased_contacts=$getcontact1["Data"]["purchased_contacts"];
		$remaining_contacts=$getcontact1["Data"]["remaining_contacts"];
		echo $userid."|".$total_visitors."|".$dnd_visitors."|".$purchased_contacts."|".$remaining_contacts."|".$email_id."|".$mobile_no."|".$gpsname;
		
	break;
	case "Add":
		
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
		
		
		$amount=explode('|',$_POST['Contact']);
		
		//$data["AddList"]["videourl"]=$_FILES["video"]['name'];
		$data["getcontact_request"]["userid"]="MGPS00051718";
		$data["getcontact_request"]["type"]=$_POST['request_type'];
		$data["getcontact_request"]["gpsid"]=$_POST["gpsid"];
		$data["getcontact_request"]["contacts"]=$_POST['Contact'];
		$data["getcontact_request"]["contacts_amount"]=$_POST['contact_amt'];
		$data["getcontact_request"]["total_amount"]=$_POST["total_amt"];
		
		
		$data["getcontact_request"]["taxdetails"]=$taxinfo1;
		$data["getcontact_request"]["transactionid"]=$_POST['rzp_payment'];
		$data["getcontact_request"]["createby"]=$_SESSION["emp_id"];
		$data["getcontact_request"]["ipaddress"]=$_SERVER['REMOTE_ADDR'];
		
		
		
		$case=base64_encode(json_encode($data,true));
		echo $rlist=WEBSERVICE."&Case=$case";
		exit;
		
		$json = file_get_contents($rlist);
		$getcontact = json_decode($json,true);
		
		$response_code=$getcontact["Response"][0]["response_code"];
		$response_msg=$getcontact["Response"][0]["response_msg"];
		echo $response_msg."|".$response_code;
		//header("Location:getcontact.php?status=".$response_code.".&msg=".$response_msg."");
		
		/* 8754065845 */
	break;
    
	case "View":
        $id=$_GET["id"];
		$db->select(GETCONTACT,'*',NULL,'id="'.$id.'"','id DESC','');
        $res = $db->getResult();
		include "layouts/common/default_header.html";
        include "layouts/common/side_bar.html";
        include "layouts/viewrecords/getcontact.html";
        include "layouts/common/default_footer.html";
		
    break;
    default:
		$db->select(GETCONTACT,'*',NULL,'','id DESC','');
        $res = $db->getResult();
		
        include "layouts/common/default_header.html";
        include "layouts/common/side_bar.html";
        include "layouts/default/getcontact.html";
        include "layouts/common/default_footer.html";
        
    break;
}
?>