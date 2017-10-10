<?php

/**
 * @author Anbazhagan.K
 * @copyright 2015
 */
 
include("includes.php");

@$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
switch ($type) {
	case "redirect_unit":
		  
		include "layouts/common/dashboard_header.html";
		include "layouts/common/side_bar.html";
		include "layouts/default/dashboard.html";
		include "layouts/common/dashboard_footer.html";
	break;
	default:
		$_SESSION["company"]=$_SESSION["company"];
		
		
		$where='created_date="'.date('Y-m-d').'"';
		$db=new Database();
		$db->connect();
		$db->select(LISTING,'*',NULL,$where,'id DESC');
        $gps_today = $db->getResult();
		
		$db=new Database();
		$db->connect();
		$db->select(LISTING,'*',NULL,'','');
        $gps_total = $db->getResult();
		
		$where='type=0';
		$db=new Database();
		$db->connect();
		$db->select(LISTING,'*',NULL,$where,'');
        $gps_individual = $db->getResult();
		
		
		$where='type=1';
		$db=new Database();
		$db->connect();
		$db->select(LISTING,'*',NULL,$where,'');
        $gps_firm = $db->getResult();
		
		
		
		
		
		
		
		
		include "layouts/common/dashboard_header.html";
		include "layouts/common/side_bar.html";
		include "layouts/default/dashboard.html";
		include "layouts/common/dashboard_footer.html";
	break;
}
?>