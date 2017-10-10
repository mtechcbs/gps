<?php 
error_reporting(0);

include("includes.php");
@$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
@$fval = isset($_POST['fval']) ? $_POST['fval'] : $_GET['fval'];

$uploadfolder="uploadfolder/";
$file_exts = array("jpg", "bmp", "jpeg", "gif", "png");
//$uploadfolder1="uploadfolder/pictures_web/";

switch($type){
	
    case "updategps":
	
	/* echo "<pre>";
	print_r($_POST); */
	
	
    $upload_exts = end(explode(".", $_FILES["picture"]["name"]));

        if($_FILES["picture"]["name"]<>""){

            if ((($_FILES["picture"]["type"] == "image/gif")|| ($_FILES["picture"]["type"] == "image/jpeg")||($_FILES["picture"]["type"] == "image/JPEG") ||($_FILES["picture"]["type"] == "image/JPG") || ($_FILES["picture"]["type"] == "image/png")|| ($_FILES["picture"]["type"] == "image/pjpeg"))&& ($_FILES["picture"]["size"] < 2097152) && in_array($upload_exts, $file_exts))
              {
                    if ($_FILES["picture"]["error"] == 0) {
                        $filename=time().".".$upload_exts;
                    move_uploaded_file($_FILES["picture"]["tmp_name"],"$uploadfolder" . $filename);
                    
                   }
				  
                   else{$filename=$_POST["pre_picture"];}
              }
              else{$filename=$_POST["pre_picture"];}
          }
          else{
            $filename=$_POST["pre_picture"];
			
          }
       	
if($_POST['gpstype']=='0'){			
	
	$data["updategps"]["gpsid"]=$_POST["gpsid"];
	$data["updategps"]["name"]=$fval["ind_name"];
	$data["updategps"]["email"]=$fval["ind_email"];
	$data["updategps"]["mobile"]=$fval["ind_ph_num"];
	$data["updategps"]["description"]=$fval["ind_description"];
	$data["updategps"]["gps_latitude"]=$fval["lat"];
	$data["updategps"]["gps_longitude"]=$fval["long"];
	$data["updategps"]["picture"]=$filename;
}
else{

//print_r($_POST);

$data["updategps"]["gpsid"]=$_POST["gpsid"];
	$data["updategps"]["name"]=$fval["firm_b_name"];
	$data["updategps"]["email"]=$fval["firm_email"];
	$data["updategps"]["mobile"]=$fval["firm_ph_num"];
	$data["updategps"]["description"]=$fval["firm_description"];
	$data["updategps"]["gps_latitude"]=$fval["lat"];
	$data["updategps"]["gps_longitude"]=$fval["long"];
	$data["updategps"]["address"]=$fval["address"];
	$data["updategps"]["city"]=$fval["city"];
	$data["updategps"]["state"]=$fval["state"];
	$data["updategps"]["country"]=$fval["country"];
	$data["updategps"]["pincode"]=$fval["pincode"];
	$data["updategps"]["category"]=$fval["category"];
	$data["updategps"]["subcategory"]=$fval["subcategory"]; 
	$data["updategps"]["picture"]=$filename;	
	$data["updategps"]["website"]=$fval["website"];	
	
}
		$case=base64_encode(json_encode($data,true));
		$rlist=WEBSERVICE."&Case=$case";	
		 echo $rlist;
		 
		$json = file_get_contents($rlist);
		$bobj1 = json_decode($json,true); 
		header("Location:gpslist.php");  
	


   
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
	
	case "state":
		$id= $_POST["id"];
		echo '<option value="">-- Select State --</option>';
        $db->select(STATE,'*',NULL,'country="'.$id.'"','id','');
        $stateres = $db->getResult();
        for($i=0;$i<count($stateres);$i++){
        echo '<option value="'.$stateres[$i]["name"].'" attr_state="'.$stateres[$i]["id"].'">'.$stateres[$i]["name"].'</option>';
		}
	break;
	case "city":
		$id= $_POST["id"];
		echo '<option value="">-- Select City --</option>';
        $db->select(CITY,'*',NULL,'state="'.$id.'"','id','');
        $cityres = $db->getResult();
        for($i=0;$i<count($cityres);$i++){
        echo '<option value="'.$cityres[$i]["name"].'">'.$cityres[$i]["name"].'</option>';
        } 
	break;
	
	
     default:	
	 
	$data["searchinfo"]["id"]=$_GET["id"];
	$data["searchinfo"]["type"]=$_GET["cattype"];
			$data["searchinfo"]["ipaddress"]=$_SERVER['REMOTE_ADDR'];
			$data["searchinfo"]["username"]=$_SESSION["gpsusername"];
			$data["searchinfo"]["devicetoken"]='web';
			$data["searchinfo"]["option"]="Edit";
			$case=base64_encode(json_encode($data,true));
			$search=WEBSERVICE."&Case=$case";
			//echo $search;
			$json = file_get_contents($search);
        	$search_result = json_decode($json,true);
			//print_r($search_result);
			
			
	 $gps_edit=$_GET['gpstype'];
	   include "layouts/common/head.html";
	   if($gps_edit==0){
	   include "layouts/default/individual_edit.html";	
	  
	   }else{
	    include "layouts/default/firm_edit.html";	
	   }
       include "layouts/common/footer.html";	 
    break;
}
?>