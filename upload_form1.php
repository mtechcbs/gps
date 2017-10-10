<body>
    <input type="file" id="myUploader"/>

    <script>
      var uploader = document.getElementById("myUploader");

      uploader.onchange = function(){
        reader = new FileReader();
        reader.onload = function(e) {
          var videoElement = document.createElement('video');
          videoElement.src = e.target.result;
          var timer = setInterval(function () {
            if (videoElement.readyState === 4){
              console.log("The duration is: " + videoElement.duration.toFixed(2) + " seconds");
              clearInterval(timer);
            }
          }, 500)
        };		
        reader.readAsDataURL(files[0]);
      }
    </script>
  </body>