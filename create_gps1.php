<?php 
error_reporting(0);

include("includes.php");
@$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
@$fval = isset($_POST['fval']) ? $_POST['fval'] : $_GET['fval'];

$uploadfolder="uploadfolder/";
$file_exts = array("jpg", "bmp", "jpeg", "gif", "png");
//$uploadfolder1="uploadfolder/pictures_web/";

switch($type){
	
	case "create_gps":
    print_r($_POST);
	exit;
	$upload_exts = end(explode(".", $_FILES["picture"]["name"]));

        if($_FILES["picture"]["name"]<>""){
			
            if ((($_FILES["picture"]["type"] == "image/gif")|| ($_FILES["picture"]["type"] == "image/jpeg")|| ($_FILES["picture"]["type"] == "image/png")|| ($_FILES["picture"]["type"] == "image/pjpeg"))&& ($_FILES["picture"]["size"] < 2097152) && in_array($upload_exts, $file_exts))
              {
                    if ($_FILES["picture"]["error"] == 0) {
                        $filename=time().".".$upload_exts;
                    move_uploaded_file($_FILES["picture"]["tmp_name"],"$uploadfolder" . $filename);
                    $fval["picture"]=$filename;
					$newname="$uploadfolder" . $filename;
					$thumb_name='uploadfolder/thumb/thumb_'.$filename;
					//echo $thumb_name;
					make_thumb($newname,$thumb_name,WIDTH,HEIGHT);
                   }
                   else{$fval["picture"]="";}
              }
              else{$fval["picture"]="";}
          }
          else{
            $fval["picture"]="";
			
          }
		  
	$data["createGPSID"]["type"]=0;
	$data["createGPSID"]["name"]=$fval["ind_name"];
	$data["createGPSID"]["email"]=$fval["ind_email"];
	$data["createGPSID"]["mobile"]=$fval["ind_ph_num"];
	$data["createGPSID"]["description"]=$fval["ind_description"];
	$data["createGPSID"]["gps_latitude"]=$fval["lat"];
	$data["createGPSID"]["gps_longitude"]=$fval["long"];
	$data["createGPSID"]["picture"]=$fval["picture"];
	$data["createGPSID"]["category"]=(empty($fval["category"])) ? '15' : $fval["category"];
	$data["createGPSID"]["subcategory"]=(empty($fval["subcategory"])) ? '0' : $fval["subcategory"];
	//$data["createGPSID"]["picture"]=$filename;
	$data["createGPSID"]["userid"]=$_SESSION["userid"];
	$data["createGPSID"]["ipaddress"]=$_SERVER['REMOTE_ADDR'];
	
		$case=base64_encode(json_encode($data,true));
		$rlist=WEBSERVICE."&Case=$case";		
		$json = file_get_contents($rlist);
		$bobj1 = json_decode($json,true); 
		
		header("Location:index.php"); 
 

	
   
	case "Ajax":
	   	
		/* print_r($_POST);
		exit(); */
		if(!empty($_POST["keyword_real"])) {			
		$where="keyword like '%" . $_POST["keyword_real"] . "%' and category='".$_POST["cat"]."' and subcategory='".$_POST["subcategory"]."'"; 
		
         $db->select(GPSDIRECTORY_KEYWORDS,'*',NULL,$where);
        $result = $db->getResult();	
        		
 
		?>
				<style>
		
		
		
		.apppurchase{color: #000;}
		.frmSearch {border: 1px solid #F0F0F0;background-color:#C8EEFD;margin: 3px 0px;padding:40px; }
		#country-list{float:left;list-style:none;margin:0;padding:0;width:100%;  max-height: 200px;
            overflow-y: auto;
            overflow-x: hidden;}
		#country-list li{padding:7px; background:#FAFAFA;border-bottom:#F0F0F0 1px solid;margin-left: 12px;text-align: left;cursor:pointer;font-size:12px;}
		#country-list li:hover{background:#F0F0F0;}
		
		</style>
		<ul id="country-list">
			<?php
			foreach($result as $country) {				
			?>
			<li class="apppurchase" onClick="selectKeyword('<?php echo $country["keyword"]; ?>');"><?php echo $country["keyword"]; ?></li>
			<?php } ?>
		</ul>
<?php
	}
    break;
	
default:

	   include "layouts/common/head.html";
	  if ($_GET["val"]=='0'){
	   include "layouts/default/gpsid_login.html";
 }else{	   include "layouts/default/create_gps.html";
	   }		   
       include "layouts/common/footer1.html";	 
    break;
}
?>