<?php



$deal_lat=10.994862;

$deal_long=76.969576;

$geocode=file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng='.$deal_lat.','.$deal_long.'&sensor=false');

        $output= json_decode($geocode);
		
    for($j=0;$j<count($output->results[0]->address_components);$j++){
               echo '<b>'.$output->results[0]->address_components[$j]->types[0].': </b>  '.$output->results[0]->address_components[$j]->long_name.'<br/>';
				
				if($output->results[0]->address_components[$j]->types[0]=="political"){
					$area=$output->results[0]->address_components[$j]->long_name;
				}
				
				if($output->results[0]->address_components[$j]->types[0]=="administrative_area_level_2"){
					$city=$output->results[0]->address_components[$j]->long_name;
				}
				if($output->results[0]->address_components[$j]->types[0]=="administrative_area_level_1"){
					$state=$output->results[0]->address_components[$j]->long_name;
				}
				if($output->results[0]->address_components[$j]->types[0]=="country"){
					$country=$output->results[0]->address_components[$j]->long_name;
				}
				
            }

echo "City := $city";
echo "State := $state";
echo "country := $country";
?>