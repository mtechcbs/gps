<?php

/**
 * @author Anbazhagan.K
 * @copyright 2015
 */

include("includes.php");

@$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
@$fval = isset($_POST['fval']) ? $_POST['fval'] : $_GET['fval'];
$uploadfolder="../uploadfolder/";
$file_exts = array("jpg", "bmp", "jpeg", "gif", "png");
switch($type){
    case "Create":
		error_reporting(0);
		
		$id=$_GET["id"];
        $db->select(LISTING,'*',NULL,'id="'.$id.'"','id','1');
        $res = $db->getResult();
		
		$id=$_GET["id"];
		$db1=new Database();
		$db1->connect();
        $db1->select(FOLLOWUP_LOG,'*',NULL,'gps_id="'.$id.'"','id DESC' );
        $res_followup = $db1->getResult();
		
		/* echo "<pre>";
		print_r($res_followup);
		exit; */ 
		
		
		
        include "layouts/common/form_header.html";
        include "layouts/common/side_bar.html";
        include "layouts/forms/gps_followup.html";
        include "layouts/common/form_footer.html";
    break;
	
	case "View":
	
		$id=$_GET['id'];
		$db->select(LISTING,'*',NULL,'id="'.$id.'"','id DESC','');
        $res = $db->getResult();
		
		
	/* 	echo "<pre>";
		print_r($res);
		exit; */
		
		
		include "layouts/common/form_header.html";
        include "layouts/common/side_bar.html";
        include "layouts/viewrecords/gps_followup.html";
        include "layouts/common/form_footer.html";
		
    break;
	case "Add":
	
		$fval["remarks"]=mysql_real_escape_string(trim($fval["remarks"]));
		
		
		
		$fval["followup_date"]=date("Y-m-d",strtotime($_POST["followup_date"]));
		$fval["followup_time"]=$_POST["followup_time"];
		
		$fval["created_date"]=date("Y-m-d H:i:s");
		$fval["created_by"]=$_SESSION["username"];
		$fval["created_ip"]=$_SERVER['REMOTE_ADDR'];
		
       $db->insert(FOLLOWUP_LOG,$fval);
	   
	  
	   header("Location:gps_followup.php");
	   
	   
	break;
    
	
    default:
		$db->select(LISTING,'*',NULL,'','id DESC','');
        $res = $db->getResult();
        include "layouts/common/default_header.html";
        include "layouts/common/side_bar.html";
        include "layouts/default/gps_followup.html";
        include "layouts/common/default_footer.html";
    break;
}

?>