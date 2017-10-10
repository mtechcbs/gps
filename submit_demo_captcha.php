<?php
session_start();

if(($_REQUEST['captcha'] == $_SESSION['vercode'])){
	$fname	=	mysql_real_escape_string($_REQUEST['fval[user]']);
	//Here you can write your sql insert statement. 
	
	echo 1;
}else{
	echo 0;
}

?>