<?php
    function getDuration($file){
    if (file_exists($file)){
     ## open and read video file
    $handle = fopen($file, "r");
    ## read video file size
    $contents = fread($handle, filesize($file));
    fclose($handle);
    $make_hexa = hexdec(bin2hex(substr($contents,strlen($contents)-3)));
    if (strlen($contents) > $make_hexa){
    $pre_duration = hexdec(bin2hex(substr($contents,strlen($contents)-$make_hexa,3))) ;
    $post_duration = $pre_duration/1000;
    $timehours = $post_duration/3600;
	
    $timeminutes =($post_duration % 3600)/60;
    $timeseconds = ($post_duration % 3600) % 60;
    $timehours = explode(".", $timehours);
    $timeminutes = explode(".", $timeminutes);
    $timeseconds = explode(".", $timeseconds);
    $duration = $timehours[0]. ":" . $timeminutes[0]. ":" . $timeseconds[0];}
	
    return $duration;
    }
    else {
    return false;
    }
    }
	
$video_file = "videouplods/VID_20170516_115818.mp4";
 echo $video_file."<br>";
echo getDuration($video_file);
	?>
	<!DOCTYPE html>
<html>
<body>

<video id="myVideo" width="320" height="240" controls>
  <source src="videouplods/VID_20170517_WA0003.mp4" type="video/mp4">
  <source src="movie.ogg" type="video/ogg">
  Your browser does not support the video tag.
</video>

<p>Click the button to get the exact length (duration) of the video, in seconds.</p>

<button onclick="myFunction()">Try it</button>

<p id="demo"></p>

<script>
function myFunction() {
    var x = document.getElementById("myVideo").duration;
    document.getElementById("demo").innerHTML = x;
}
</script>

</body>
</html>