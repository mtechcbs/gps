<?php
error_reporting(E_ALL);
include("includes.php");
$db->select(LISTING,'*',NULL,'','','');
$res = $db->getResult();
if(count($res)>0){
	for($i=0;$i<count($res);$i++){
		$gpsid=$res[$i]['gpsid'];
		$id=$res[$i]['id'];
		$db2=new Database();
		$db2->connect();
		$db2->select(VISITORLOG,'COUNT(gpsid) as visitcount',NULL,'gpsid="'.$gpsid.'"','','');
		$resvisitcnt = $db2->getResult();
		$fval['visitcount']=$resvisitcnt[0]['visitcount'];
		$db=new Database();
		$db->connect();
		$db->update(LISTING,$fval,'id="'.$id.'"'); 
		/* print_r($db); */
	}
}else{
	echo "updated";
	
}
?>