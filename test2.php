<?php
require('pdf/fpdf/fpdf.php');
include("includes.php");
$msg='{"Response":[{"response_code":"1","response_msg":"Receipt Informations"}],"Result":[{"fancyid":"keerthi09","id":"1","plan":"Fancy Id","class":"1 Year","amount":"5000","tax":{"ServiceTax":700,"SwachhBharatCess":25,"KrishiKalyanCess":25,"TrancationFee":150},"TotalAmount":5900,"name":"keerthiman","gpsid":"Z4UU84","expiredate":"2018-06-02","fromdate":"2017-06-02","invoice_no":"0002","invoicedate":"2017-06-02 00:00:00"}]}';
$search_result = json_decode("$msg",true);
//echo "<pre>";
//print_r($search_result);
$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();
$pdf->AddFont('MicrosoftSansSerif','','micross.php');
$pdf->Image('assets/images/top.png',2,02,206);
$pdf->Rect(2,40,206,10);
$pdf->SetFont('Arial','B',20);
$pdf->SetFont('Arial','B',14);

$pdf->Ln(30);

$pdf->SetFont('MicrosoftSansSerif','',13);
$pdf->Cell(35,10,'Invoice No   :',0,0,'L',0);
$pdf->SetFont('MicrosoftSansSerif','',13);
$pdf->Cell(80,10,$search_result["Result"][0]["invoice_no"],0,0,'L');

$pdf->SetFont('MicrosoftSansSerif','',13);
$pdf->Cell(40,10,'Invoice Date   :',0,0,'L',0);
$pdf->SetFont('MicrosoftSansSerif','',13);
$pdf->Cell(100,10,date("d-M-Y",strtotime($search_result["Result"][0]["invoicedate"])),0,1,'L');

$pdf->Ln(10);

$name=$search_result["Result"][0]["name"];
$pdf->SetFont('MicrosoftSansSerif','',10);
$pdf->Cell(50,12,"Name",0,0,'L',0);
$pdf->SetFont('MicrosoftSansSerif','',10);
$pdf->Cell(50,12,": $name",0,1,'L');
$pdf->Ln(-7);

$gpsid=$search_result["Result"][0]["gpsid"];
$pdf->SetFont('MicrosoftSansSerif','',10);
$pdf->Cell(50,12,"GPS ID",0,0,'L',0);
$pdf->SetFont('MicrosoftSansSerif','',10);
$pdf->Cell(50,12,": $gpsid",0,1,'L');
$pdf->Ln(-7);

$fancyid=$search_result["Result"][0]["fancyid"];
$pdf->SetFont('MicrosoftSansSerif','',10);
$pdf->Cell(50,12,"Fancy ID",0,0,'L',0);
$pdf->SetFont('MicrosoftSansSerif','',10);
$pdf->Cell(50,12,": $fancyid",0,1,'L');
$pdf->Ln(-7);

$plan=$search_result["Result"][0]["plan"]." - ".$search_result["Result"][0]["class"];
$pdf->SetFont('MicrosoftSansSerif','',10);
$pdf->Cell(50,12,"Plan",0,0,'L',0);
$pdf->SetFont('MicrosoftSansSerif','',10);
$pdf->Cell(50,12,": $plan",0,1,'L');
$pdf->Ln(-7);

$fromdate=date("d-M-Y",strtotime($search_result["Result"][0]["fromdate"]));
$pdf->SetFont('MicrosoftSansSerif','',10);
$pdf->Cell(50,12,"From Date",0,0,'L',0);
$pdf->SetFont('MicrosoftSansSerif','',10);
$pdf->Cell(50,12,": $fromdate",0,1,'L');
$pdf->Ln(-7);
$todate=date("d-M-Y",strtotime($search_result["Result"][0]["expiredate"]));
$pdf->SetFont('MicrosoftSansSerif','',10);
$pdf->Cell(50,12,"To Date",0,0,'L',0);
$pdf->SetFont('MicrosoftSansSerif','',10);
$pdf->Cell(50,12,": $todate",0,1,'L');
$pdf->Ln(-7);
$pdf->Ln(2);
//$todate=date("d-M-Y",strtotime($search_result["Result"][0]["expiredate"]));
$pdf->SetFont('MicrosoftSansSerif','',14);
$pdf->SetTextColor(153,153,0);
$pdf->Cell(50,12,"Payment Summary",0,0,'L',0);
$pdf->SetFont('MicrosoftSansSerif','',10);
$pdf->Cell(50,12," ",0,1,'L');
$pdf->Ln(-3);

$fairdesc1=ucwords(strtolower("amount"));
$fairamt1=number_format($search_result["Result"][0]["amount"],2);

$pdf->SetFont('MicrosoftSansSerif','',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(50,12,"$fairdesc1",0,0,'L',0);
$pdf->SetFont('MicrosoftSansSerif','',10);

$pdf->Cell(50,12,": $fairamt1",0,1,'L');
$pdf->Ln(-7);
foreach($search_result["Result"][0]["tax"] as $key => $val){
	  $fairdesc1=ucwords(strtolower($key));
	  $fairamt1=number_format($val,2);

$pdf->SetFont('MicrosoftSansSerif','',10);
$pdf->Cell(50,12,"$fairdesc1",0,0,'L',0);
$pdf->SetFont('MicrosoftSansSerif','',10);
$pdf->Cell(50,12,": $fairamt1",0,1,'L');
$pdf->Ln(-7);
  }
  $pdf->Ln(2);
  $fairdesc1=ucwords(strtolower("Total Amount"));
$fairamt1=number_format($search_result["Result"][0]["TotalAmount"],2);

$pdf->SetFont('MicrosoftSansSerif','',14);
$pdf->SetTextColor(153,153,0);
$pdf->Cell(50,12,"$fairdesc1",0,0,'L',0);
$pdf->SetFont('MicrosoftSansSerif','',14);
$pdf->Cell(50,12,": $fairamt1",0,1,'L');
$pdf->Ln(-7);
$pdf->Output("Invoice_gpsdirectory.pdf","I");
$pdf->SetTextColor(50,60,100);	
?>