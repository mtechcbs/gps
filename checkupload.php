<?php
include("includes.php");
if(isset($_POST["upload"])){
       $upload_exts = end(explode(".", $_FILES["uploadedfile"]["name"]));
        $filename=time().".".$upload_exts;
        $file=current(explode(".", $filename));
        
        
    //$file_name=time().".".$upload_exts;
    
    $upload_exts = end(explode(".", $_FILES["uploadedfile"]["name"]));
    $file_name=time().".".$upload_exts;
	$dataimg = array(
                        'file' => new CURLFile($_FILES['uploadedfile']['tmp_name'],$_FILES['uploadedfile']['type'], $_FILES['uploadedfile']['name']),
                        'destination' => 'videouplods',
                        'calling_method' => 'upload_file',
                        'file_name' => $filename
                    ); 
                    
                   echo videoupload_server($dataimg);
}
?>
        <div class="row">
          <div class="col-sm-6 col-sm-offset-4 col-md-6 col-md-offset-2 upload">
			<i class="fa fa-cloud-upload" aria-hidden="true" style="color:#b1b3b7;font-size:40px;"></i>

              <p style="color:#b1b3b7;font-size:23px;">Upload Product Video here</p>
              <form role="form" class="login-form" method="post" action="checkupload.php" enctype="multipart/form-data" id="login_form">
              <div class="form-group">
					<input type="file" class="form-control" id="" name="uploadedfile" accept="video/*"/>
			 	</div>
              <div class="col-md-6 col-md-offset-3 col-xs-12" style="margin-top:30px;">
				            <button type="submit" name="upload" class="btn btn-primary btn-md" id="self_btn">Submit</button>
			 </div>
			 
			 
			 
               <!--  <button type="submit" class="btn btn-common log-btn">Send me my Password</button> -->
              </form>
        
          </div>
		   
        </div>
       