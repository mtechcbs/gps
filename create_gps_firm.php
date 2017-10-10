<?php 
//error_reporting(0);

include("includes.php");
@$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
@$fval = isset($_POST['fval']) ? $_POST['fval'] : $_GET['fval'];

$uploadfolder="uploadfolder/";
$file_exts = array("jpg", "bmp", "jpeg", "gif", "png");
//$uploadfolder1="uploadfolder/pictures_web/";


switch($type){
	case "create_gps_firm":
    //print_r($_POST);
	$upload_exts = end(explode(".", $_FILES["picture"]["name"]));

        if($_FILES["picture"]["name"]<>""){
			
            if ((($_FILES["picture"]["type"] == "image/gif")|| ($_FILES["picture"]["type"] == "image/jpeg")|| ($_FILES["picture"]["type"] == "image/png")|| ($_FILES["picture"]["type"] == "image/pjpeg"))&& ($_FILES["picture"]["size"] < 2097152) && in_array($upload_exts, $file_exts))
              {
                    if ($_FILES["picture"]["error"] == 0) {
                        $filename=time().".".$upload_exts;
                    /*move_uploaded_file($_FILES["picture"]["tmp_name"],"$uploadfolder" . $filename);
                    $fval["picture"]=$filename;
					
					$newname="$uploadfolder" . $filename;
					$thumb_name='uploadfolder/thumb/thumb_'.$filename;
					//echo $thumb_name;
					make_thumb($newname,$thumb_name,WIDTH,HEIGHT);*/
                    
                    $dataimg = array(
                        'file' => new CURLFile($_FILES['picture']['tmp_name'],$_FILES['picture']['type'], $_FILES['picture']['name']),
                        'destination' => 'uploadfolder',
                        'calling_method' => 'upload_file',
                        'file_name' => $filename,
                        'bannertype'=>0
                    ); 
                    
                    fileupload_server($dataimg);
                    
					
                   }
                   else{$fval["picture"]="";}
              }
              else{$fval["picture"]="";}
          }
          else{
            $fval["picture"]="";
			
          }
		  
		 
		
		$data["createGPSID"]["type"]=1;
		$data["createGPSID"]["name"]=$fval["firm_b_name"];
		$data["createGPSID"]["email"]=$fval["firm_email"];
		$data["createGPSID"]["mobile"]=$fval["firm_ph_num"];
		$data["createGPSID"]["landline"]=$fval["landline"];
		$data["createGPSID"]["description"]=$fval["firm_description"];
		$data["createGPSID"]["keyword"]=$fval["keyword"];
		$data["createGPSID"]["gps_latitude"]=$_POST["lat"];
		$data["createGPSID"]["gps_longitude"]=$_POST["long"];
		
		$data["createGPSID"]["category"]=(empty($fval["category"])) ? '16' : $fval["category"];
		$data["createGPSID"]["subcategory"]=(empty($fval["subcategory"])) ? '64' : $fval["subcategory"];
		$data["createGPSID"]["website"]=$fval["website"];
		$data["createGPSID"]["picture"]=$filename;
		$data["createGPSID"]["userid"]=$_SESSION["userid"];
		$data["createGPSID"]["ipaddress"]=$_SERVER['REMOTE_ADDR'];
		
		/* $data["createGPSID"]["address"]=$address;
		$data["createGPSID"]["area"]=$area;
		$data["createGPSID"]["city"]=$city_list;
		$data["createGPSID"]["state"]=$state_list;
		$data["createGPSID"]["country"]=$country_list;
		$data["createGPSID"]["pincode"]=$pincode; */
		
		
			
		$case=base64_encode(json_encode($data,true));
		$rlist=WEBSERVICE."&Case=$case";		
		$json = file_get_contents($rlist);
		$bobj1 = json_decode($json,true); 
	    $code1=$bobj1["Response"][0]["response_code"];
		$msg1=$bobj1["Response"][0]["response_msg"];
		
		echo "#@#";
		
		echo $code1;
		echo "#@#";
		echo $msg1;
 
break;
     default:	
	 
	   include "layouts/common/head.html";
	  if ($_GET["val"]=='1'){
	   include "layouts/default/gpsid_login.html";
 }else{	   include "layouts/default/create_gps_firm.html";
	   }		
       include "layouts/common/footer1.html";	 
    break;
}
?>