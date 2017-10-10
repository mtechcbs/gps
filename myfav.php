<?php 
error_reporting(0);

include("includes.php");
@$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
@$fval = isset($_POST['fval']) ? $_POST['fval'] : $_GET['fval'];
switch($type){
	
	case "removefavourite":
				$removefavourite["removefavourite"]["username"]=$_SESSION["userid"];
				$removefavourite["removefavourite"]["gpsid"]=$_POST["gpsid"];
	            $case=base64_encode(json_encode($removefavourite,true));				
				$rlist=WEBSERVICE."&Case=$case";
			    //echo $rlist;
                $json = file_get_contents($rlist);
                $bobj = json_decode($json,true);
				echo $bobj["Response"]["0"]["response_msg"];
				//print_r($bobj);
	break;

     default:	
	 $myfavourite["myfavourite"]["userid"]=$_SESSION["userid"];
				
                
				$case=base64_encode(json_encode($myfavourite,true));				
				 $rlist=WEBSERVICE."&Case=$case";	
                $json = file_get_contents($rlist);
                $search_result = json_decode($json,true);
			    $search_result["Response"]["0"]["response_msg"];
		
	   include "layouts/common/head.html";
	   if ($_GET["login"]=='0'){
		include "layouts/default/gpsid_login.html";
	   }else{
	   include "layouts/default/myfav.html";	
	   }
       include "layouts/common/footer.html";	 
    break;
}
?>