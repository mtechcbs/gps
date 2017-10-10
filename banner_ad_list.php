<?php 
error_reporting(0);

include("includes.php");
@$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
@$fval = isset($_POST['fval']) ? $_POST['fval'] : $_GET['fval'];
switch($type){
	
       default:	

	    include "layouts/common/head.html";
		include "layouts/default/banner_ad_list.html";   
        include "layouts/common/footer1.html";	 
    break;
}
?>