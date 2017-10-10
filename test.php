<?php
include("includes.php");
$data["planinfo"]["plan"]='Self Display';//$_SESSION["userid"];
		$case=base64_encode(json_encode($data,true));
		$rlist=WEBSERVICE."&Case=$case";
		echo $rlist;
?>