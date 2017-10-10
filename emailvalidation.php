<?php
include("includes.php");
@$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
@$fval = isset($_POST['fval']) ? $_POST['fval'] : $_GET['fval'];
// The code bellow demonstrates a simple back-end written in PHP
// Determine which field you want to check its existence
$isAvailable = true;
$table=APPUSER;

$db->select("$table",'*',NULL,'email_id="'.$fval["email"].'"','id','1');
$res = $db->getResult();
//print_r($res);
if(count($res)>0){
	$isAvailable = false;
}else{
	$isAvailable = true;
}

// Finally, return a JSON
echo json_encode(array(
    'valid' => $isAvailable,
));

