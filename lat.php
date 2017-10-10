<html>
<form method="POST">
<input type="hidden" name="lat">
<input type="hidden" name="lng">
<input type="text" name="location">
<input type="submit" name="submit" value="submit">
</form>
</html>


<?php
// We define our address
$address = 'Caen, Basse-Normandie';
// We get the JSON results from this request
$geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false');
// We convert the JSON to an array
$geo = json_decode($geo, true);
// If everything is cool
if ($geo['status'] = 'OK') {
  // We set our values
  $latitude = $geo['results'][0]['geometry']['location']['lat'];
  $longitude = $geo['results'][0]['geometry']['location']['lng'];
}

?>