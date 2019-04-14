<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$receitp_code = '12345';
tcpdf();
	$obj_pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$obj_pdf->SetCreator(PDF_CREATOR);
	$title = "Receipt No.".$receitp_code;

	$obj_pdf->SetTitle($title);
	#$obj_pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title, PDF_HEADER_STRING);
	$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	$obj_pdf->SetDefaultMonospacedFont('times');
	$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	$obj_pdf->SetPrintHeader(false);
	$obj_pdf->SetPrintFooter(false);

	$obj_pdf->SetMargins(10,10,10); //PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT
	$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	$obj_pdf->SetFont('times', '', 14);
	$obj_pdf->setFontSubsetting(false);
	
	//$obj_pdf->SetCellPadding(0);
	// set image scale factor
	$obj_pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	$obj_pdf->AddPage();
	ob_start();
	
	
	// we can have any view part here like HTML, PHP etc
	// define some HTML content with style

		include('receipt-content.php');
		$html .= ob_get_contents();
		#$content .= PDF_MARGIN_LEFT;
		
	ob_end_clean();
	$obj_pdf->writeHTML($html, true, false, true, false, '');
	
	$obj_pdf->Output($receitp_code.'.pdf', 'I');  // Direct Preview

	
?>