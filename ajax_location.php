<?php
include("includes.php");
$id= $_POST["id"];

if($_POST["case"]=="subcategory"){
        echo '<option value="">-- Select Subcategory --</option>';
        $db->select(SUBCATEGORY,'*',NULL,'category="'.$id.'"','subcategory','');
        $stateres = $db->getResult();
        for($i=0;$i<count($stateres);$i++){
        echo '<option value="'.$stateres[$i]["id"].'" >'.$stateres[$i]["subcategory"].'</option>';
    }
}


if($_POST["case"]=="state"){
        echo '<option value="">-- Select State --</option>';
        $db->select(STATE,'*',NULL,'country="'.$id.'"','id','');
        $stateres = $db->getResult();
        for($i=0;$i<count($stateres);$i++){
        echo '<option value="'.$stateres[$i]["id"].'">'.$stateres[$i]["name"].'</option>';
    }
}
if($_POST["case"]=="city"){
        echo '<option value="">-- Select City --</option>';
        $db->select(CITY,'*',NULL,'state="'.$id.'"','id','');
        $cityres = $db->getResult();
        for($i=0;$i<count($cityres);$i++){
        echo '<option value="'.$cityres[$i]["id"].'">'.$cityres[$i]["name"].'</option>';
        }    
    
} 
?>