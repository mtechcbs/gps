<?php
include("includes.php");
print_r($_POST);
if(isset($_POST["btn_upload"])){
	print_r($_FILES);
$upload_exts = end(explode(".", $_FILES["uploadedfile"]["name"]));
$filename=time().".".$upload_exts;
$data = array(
    'file' => new CURLFile($_FILES['uploadedfile']['tmp_name'],$_FILES['uploadedfile']['type'], $_FILES['uploadedfile']['name']),
    'destination' => 'uploadfolder',
    'calling_method' => 'upload_file',
    'file_name' => $filename
); 
print_r($data);
echo fileupload_server($data);
}
?>



 <form class="form-ad" role="form" method="post" id="basicBootstrapForm_firm" enctype='multipart/form-data' action="uploadfile.php"> 
 <div class="col-md-12 col-xs-12">
				 
                       <div class="form-group ">
					     <label class="control-label">Upload your Image</label>
                              <input type="file" class="form-control"  name="uploadedfile"  id="imgfile" accept="image/png, image/jpeg" />   
	                       <span style="color: #a7a1a1;"><b>(Note:&nbsp;Maximum Photo upload size 2MB)</b></span> 							  
                           </div>
			 <div class="form-group" >
                              <div class="col-md-12 col-md-offset-5 col-xs-12" >
                                 <button type="submit" class="btn btn-primary" value='upload' name='btn_upload'  style="margin-top:10px;margin-bottom:20px;" >Submit</button>
                              </div>
                           </div>
				
				  </div>
                  </form>