<?php
session_start();
error_reporting(0);
include("includes/tables.php");
include("Class/mtech_curd_class.php");
$db = new Database();
$db->connect();	
include("includes/functions.php");
$auth = gen_auth("tpin_android_gpsuser","gpsandroiduser");
//define("WEBSERVICE","http://gpsdirectory.net/Scripts/V1/web_service.php?Auth=".$auth);
define("WEBSERVICE","http://52.2.164.188/Scripts/V1/web_service.php?Auth=".$auth);				
?>