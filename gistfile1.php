<?php
//where you want your thumbnails to go
$thumbs_dir = 'uploads/thumbs/';

//this should be an array of video paths
$videos = array();

if( $_POST["name"] ){
    // Grab the MIME type and the data with a regex for convenience
    if (!preg_match('/data:([^;]*);base64,(.*)/', $_POST['data'], $matches)) {
        die("error");
    }
    
    // Decode the data
    $data = $matches[2];
    $data = str_replace(' ','+',$data);
    $data = base64_decode($data);
    
    file_put_contents($thumbs_dir.$file, $data);
    
    print 'done '.$name;
    exit;
}
?>

<video id="video" src=""  onerror="failed(event)" controls="controls" preload="none"></video>

<script>
var videos = <?=json_encode($videos);?>;
var index = 0;
var video = document.getElementById('video');

video.addEventListener('canplay', function() {
    this.currentTime = this.duration / 2;
}, false);

video.addEventListener('seeked', function() {
    getThumb();
}, false);

function nextVideo(){
    if(videos[index]){        
        video.src = '/uploads/'+videos[index];
        console.log(index);
        console.log('loading: '+video.src);
        video.load();
        index++;
    }else{
        console.log('done');
    }
}

function getThumb(){
    var filename = video.src;
    var w = video.videoWidth;//video.videoWidth * scaleFactor;
    var h = video.videoHeight;//video.videoHeight * scaleFactor;
    var canvas = document.createElement('canvas');

    canvas.width = w;
    canvas.height = h;
    var ctx = canvas.getContext('2d');
    ctx.drawImage(video, 0, 0, w, h);

    //document.body.appendChild(canvas);
    var data = canvas.toDataURL("image/jpg");
    
    //send to php script
    var xmlhttp = new XMLHttpRequest;
    
    xmlhttp.onreadystatechange = function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            console.log('saved');
            nextVideo();
        }
    }
    
    console.log('saving');
    xmlhttp.open("POST", location.href, true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send('name='+encodeURIComponent(filename)+'&data='+data);
}

function failed(e) {
    // video playback failed - show a message saying why
    switch (e.target.error.code) {
        case e.target.error.MEDIA_ERR_ABORTED:
            console.log('You aborted the video playback.');
        break;
        case e.target.error.MEDIA_ERR_NETWORK:
            console.log('A network error caused the video download to fail part-way.');
        break;
        case e.target.error.MEDIA_ERR_DECODE:
            console.log('The video playback was aborted due to a corruption problem or because the video used features your browser did not support.');
        break;
        case e.target.error.MEDIA_ERR_SRC_NOT_SUPPORTED:
            console.log('The video could not be loaded, either because the server or network failed or because the format is not supported.');
        break;
        default:
            console.log('An unknown error occurred.');
        break;
    }
    
    nextVideo();
}
 
//let's go
nextVideo();
</script>