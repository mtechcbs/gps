<?php
include("includes.php");
//print_r($_POST);
$data["banner_count_update"]["banner_id"]=$_POST["bannerid"];
$data["banner_count_update"]["count"]=1;
$data["banner_count_update"]["type"]=$_POST["btype"];
$data["banner_count_update"]["ipaddress"]=$_SERVER['REMOTE_ADDR'];
$data["banner_count_update"]["username"]=$_SESSION["userid"];
$data["banner_count_update"]["devicetoken"]='web';
$data["banner_count_update"]["latitude"]=$_POST["lat"];
$data["banner_count_update"]["longitude"]=$_POST["long"];
$case=base64_encode(json_encode($data,true));
$cjobs=WEBSERVICE."&Case=$case";
echo $cjobs;
$json = file_get_contents($cjobs);
$cjobslist = json_decode($json,true);
?>