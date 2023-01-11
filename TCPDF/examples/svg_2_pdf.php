<?php
//============================================================+
// File name   : svg_2_pdf.php
// Begin       : 2010-04-22
// Last Update : 2013-05-14
//
// Description : Example 058 for TCPDF class
//               SVG Image
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: SVG Image
 * @author Nicola Asuni
 * @since 2010-05-02
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Ugly Christmas Sweater');
$pdf->SetTitle(' SVG as a PDF');
$pdf->SetSubject('Order # 000001');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' .', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 10);

// add a page
$pdf->AddPage();

// NOTE: Uncomment the following line to rasterize SVG image using the ImageMagick library.
//$pdf->setRasterizeVectorImages(true);

$pdf->ImageSVG($file='svg/1513153284_svg_sleeve.svg', $x=15, $y=30, $w='', $h='', $link='', $align='', $palign='', $border=1, $fitonpage=true);
$pdf->AddPage();
$pdf->ImageSVG($file='svg/1513153284_svg_front.svg', $x=15, $y=30, $w='', $h='', $link='', $align='', $palign='', $border=0, $fitonpage=true);
$pdf->AddPage();
$pdf->ImageSVG($file='svg/1513153284_svg_back.svg', $x=15, $y=30, $w='', $h='', $link='', $align='', $palign='', $border=0, $fitonpage=true);

//$pdf->SetFont('helvetica', '', 8);
//$pdf->SetY(695);
//$txt = '© The copyright holder of the above Tux image is Larry Ewing, allows anyone to use it for any purpose, provided that the copyright holder is properly attributed. Redistribution, derivative work, commercial use, and all other use is permitted.';
//$pdf->Write(0, $txt, '', 0, 'L', true, 0, false, false, 0);

// ---------------------------------------------------------
$fname=time().'_svg.pdf';
//Close and output PDF document
$pdf->Output($_SERVER['DOCUMENT_ROOT'].'/Ishtiaq-dev/sweater-new/wp-content/uploads/pdf/'.$fname, 'F'); // D
echo "<h2 align='center'>File location <a target='_blank' href='http://production.technology-architects.com/Ishtiaq-dev/sweater-new/wp-content/uploads/pdf/".$fname."'>Here</a><h2>";
//============================================================+
// END OF FILE
//============================================================+
