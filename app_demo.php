<?php 
error_reporting(0);

include("includes.php");

switch($type){
	
     default:
			
	   include "layouts/common/head.html";
	   include "layouts/common/ajax_autocomplete.html";
	   include "layouts/default/app_demo.html";	
       include "layouts/common/footer.html";	 
    break;
}
?>