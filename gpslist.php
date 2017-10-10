<?php 
error_reporting(0);

include("includes.php");
@$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
@$fval = isset($_POST['fval']) ? $_POST['fval'] : $_GET['fval'];
switch($type){
	
	
	
	
	case "Ajax":
	//print_r();
		if(!empty($_POST["keyword"])) {
		$where="keyword like '%" . $_POST["keyword"] . "%' )"; 
         $db->select(GPSDIRECTORY_KEYWORDS,'*',NULL,$where);
        $result = $db->getResult();	
		print_r($result);		
		?>
		
		<ul id="country-list">
			<?php
			foreach($result as $country) {
			?>
			<li onClick="selectCountry('<?php echo $country["country_name"]; ?>');"><?php echo $country["country_name"]; ?></li>
			<?php } ?>
		</ul>
<?php
	}
     default:	
	 //print_r($_GET);
	 //exit;
	    $data["mygpsids"]["email"]=$_SESSION["userid"];
		$data["mygpsids"]["mobile"]=$_SESSION["mobile_number"];
		$case=base64_encode(json_encode($data,true));
		 $rlist=WEBSERVICE."&Case=$case";
		//echo $rlist;
		$json = file_get_contents($rlist);
		$bobj1 = json_decode($json,true);
       
	   $ind_array= array();
	   $firm_array= array();
	   $j=0; $k=0;
	  // echo count($bobj1["Result"]);
	   for($i=0;$i<count($bobj1["Result"]);$i++){
		   if($bobj1["Result"][$i]['type']=="0"){
			  $ind_array[$j]["gpsid"]=$bobj1["Result"][$i]['gpsid']; 
			  $ind_array[$j]["fancyid"]=$bobj1["Result"][$i]['fancyid'];
			  $ind_array[$j]["name"]=$bobj1["Result"][$i]['name'];
			  $ind_array[$j]["id"]=$bobj1["Result"][$i]['id'];
			  $ind_array[$j]["type"]=$bobj1["Result"][$i]['type'];
			  $ind_array[$j]["gps_latitude"]=$bobj1["Result"][$i]['gps_latitude'];
			  $ind_array[$j]["gps_longitude"]=$bobj1["Result"][$i]['gps_longitude'];
			  $ind_array[$j]["visitcount"]=$bobj1["Result"][$i]['visitcount'];
			  $j=$j+1;
		   }
		   else{
			   $firm_array[$k]["gpsid"]=$bobj1["Result"][$i]['gpsid'];
			   $firm_array[$k]["fancyid"]=$bobj1["Result"][$i]['fancyid'];
			   $firm_array[$k]["name"]=$bobj1["Result"][$i]['name']; 
			   $firm_array[$k]["id"]=$bobj1["Result"][$i]['id'];
			   $firm_array[$k]["type"]=$bobj1["Result"][$i]['type']; 
			   $firm_array[$k]["gps_latitude"]=$bobj1["Result"][$i]['gps_latitude'];
			   $firm_array[$k]["gps_longitude"]=$bobj1["Result"][$i]['gps_longitude'];
			   $firm_array[$k]["visitcount"]=$bobj1["Result"][$i]['visitcount'];
			    $k=$k+1;
		   }
	   }
	   
	   include "layouts/common/head.html";
	   if ($_GET["type"]=='0'){
	   include "layouts/default/gpsid_login.html";
	   }else{
	   include "layouts/default/gpslist.html";
	   }		   
        include "layouts/common/footer.html";	 
    break;
}
?>