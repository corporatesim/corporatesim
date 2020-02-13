<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once '../tcpdf/tcpdf.php'; 
class MYPDF extends TCPDF
{	
	//Page header
	public function Header()
	{
		// get the current page break margin
		$bMargin = $this->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $this->AutoPageBreak;
		// disable auto-page-break
		$this->SetAutoPageBreak(false, 0);
		// set bacground image
		$img_file = K_PATH_IMAGES.'../../../images/watermark.png';
		$this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
		// restore auto-page-break status
		$this->SetAutoPageBreak($auto_page_break, $bMargin);
		// set the starting point for the page content
		// $this->setPageMark();

    // Enterprise Logo
		if(Enterprise_Logo != 'noVal')
		{
			// if there is enterprise logo then only show ent logo
			$image_file = K_PATH_IMAGES.'../../../enterprise/common/Logo/'.Enterprise_Logo;
			$ext        = explode('.',Enterprise_Logo);
			$extension  = strtolower(end($ext));
			$this->Image($image_file, 10, 10, 20, '',$extension, '', 'T', false, 300, '', false, false, 0, false, false, false);
		}
		// if(Enterprise_Name != 'noVal')
		// {
		// 	// if there is enterprise name then only show the name of enterprise
		// 	$this->Cell(0, 15, Enterprise_Name, 0, false, 'A', 0, '', 0, false, 'T', 'B');
		// }

    // Humanlinks Logo
		$image_file = K_PATH_IMAGES.'../../../images/logo.png';
		$this->Image($image_file, 90, 10, 20, '', 'png', 'https://humanlinks.in/', 'T', false, 300, '', false, false, 0, false, false, false);
		// $this->Cell(0, 15, ' Humanlinks ', 0, false, 'B', 0, 'https://humanlinks.in/', 0, false, 'T', 'B');

    // Sub-Enterprise Logo
		if(SubEnterprise_Logo != 'noVal')
		{
			$image_file = K_PATH_IMAGES.'../../../enterprise/common/Logo/'.SubEnterprise_Logo;
			$ext        = explode('.',SubEnterprise_Logo);
			$extension  = strtolower(end($ext));
			$this->Image($image_file, 150, 10, 20, '', $extension, '', 'T', false, 300, '', false, false, 0, false, false, false);
		}
		// if(SubEnterprise_Name != 'noVal')
		// {
		// 	// if there is subEnterprise name then only show the name of enterprise
		// 	$this->Cell(0, 15, SubEnterprise_Name, 0, false, 'C', 0, '', 0, false, 'T', 'B');
		// }

    // Set font
		$this->SetFont('helvetica', 'B', 20);
	}

    // Page footer
	public function Footer()
	{
    // Position at 15 mm from bottom
		$this->SetY(-15);
    // Set font
		$this->SetFont('helvetica', 'I', 8);
    // Page number
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}