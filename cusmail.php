<?php
$from = "support@gpsdirectory.net"; 
$subject = "Invoice from GPS Directory"; 
$separator = md5(time());
$eol = PHP_EOL;
$to="anbuk4u@gmail.com";
ob_start();
include("emailtemplate/prioritylisting.html");
$content = ob_get_contents();
ob_end_clean();
$path="http://gpsdirectory.net/emailtemplate/images/";
$content=str_replace("images/","$path",$content);
		
//echo $content;
$message = $content;




$headers = "From: " . $from . "\r\n";
$headers .= "Reply-To: ". $from . "\r\n";
//$headers .= "Cc: info@gpsdirectory.net \r\n";
//$headers .= "Bcc: anbu@mtechsolutions.org \r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

//$pdf->SetTextColor(50,60,100);
/*$headers  = "From: ".$from.$eol;
$headers .= "MIME-Version: 1.0".$eol; 
$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"";*/

// no more headers after this, we start the body! //

/*$body = "--".$separator.$eol;
$body .= "Content-Transfer-Encoding: 7bit".$eol.$eol;
//$body .= "This is a MIME encoded message.".$eol;*/

// message
/*$body .= "--".$separator.$eol;
$body .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
$body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
$body .= $message.$eol;*/

// attachment
/*$body .= "--".$separator.$eol;
//$body .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol; 
$body .= "Content-Transfer-Encoding: base64".$eol;
$body .= "Content-Disposition: attachment".$eol.$eol;
$body .= $attachment.$eol;
$body .= "--".$separator."--";*/

// send message
echo $message;
mail($to, $subject, $message, $headers);
?>