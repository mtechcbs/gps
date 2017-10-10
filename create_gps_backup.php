<?php 
error_reporting(0);

include("includes.php");
@$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
@$fval = isset($_POST['fval']) ? $_POST['fval'] : $_GET['fval'];
switch($type){
	/*case "Ajax":
	
	$address=$_POST['address'];
	 
function getLatLong($address){
    if(!empty($address)){
        //Formatted address
        $formattedAddr = str_replace(' ','+',$address);
        //Send request and receive json data by address
        $geocodeFromAddr = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false'); 
        $output = json_decode($geocodeFromAddr);
        //Get latitude and longitute from json data
        $data['latitude']  = $output->results[0]->geometry->location->lat; 
        $data['longitude'] = $output->results[0]->geometry->location->lng;
        //Return latitude and longitude of the given address
        if(!empty($data)){
            return $data;
        }else{
            return false;
        }
    }else{
        return false;   
    }
}
/**
 * Use getLatLong() function like the following.
 
$address = $_POST['address'];
$latLong = getLatLong($address);
echo $latitude = $latLong['latitude']?$latLong['latitude']:'Not found';
echo "/";
echo $longitude = $latLong['longitude']?$latLong['longitude']:'Not found';
	 
	break;*/
	
     default:	
	   include "layouts/common/head.html";
	   include "layouts/common/ajax_autocomplete.html";
	   include "layouts/default/create_gps.html";	
       include "layouts/common/footer.html";	 
    break;
}
?>