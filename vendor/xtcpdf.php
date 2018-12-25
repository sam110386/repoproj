<?php

include base_path('vendor/tcpdf/tcpdf.php');

class XTCPDF extends TCPDF {

    var $xheadertext = '';
    var $xheadercolor = array();
    var $xfootertext = 'SGS © 2019. All rights reserved.';
    var $xfooterfont = PDF_FONT_NAME_MAIN;
    var $xfooterfontsize = 8;

    /**
     * Overwrites the default header
     * set the text in the view using
     *    $fpdf->xheadertext = 'YOUR ORGANIZATION';
     * set the fill color in the view using
     *    $fpdf->xheadercolor = array(0,0,100); (r, g, b)
     * set the font in the view using
     *    $fpdf->setHeaderFont(array('YourFont','',fontsize));
     */
    function Header() {
    
        list($r, $b, $g) = $this->xheadercolor;
        $this->setY(10); // shouldn't be needed due to page margin, but helas, otherwise it's at the page top
        $this->SetFillColor($r, $b, $g);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(0, 20, '', 0, 1, 'C', 1);
        $this->Text(15, 26, $this->xheadertext);
    }
    
//    function Header()
//    {   
//	$image_file = K_PATH_IMAGES.'logo.png';
//	$this->Image($image_file, 0, 0, 220, '', 'PNG', '', 'T', true, 300, '', false, false, 0, false, false, false);
//    }

// function Header()
//    {   
//	$image_file = K_PATH_IMAGES.'logo.png';
//	$this->Image($image_file, 60, 15, 80, '', 'PNG', '', 'T', true, 300, '', false, false, 0, false, false, false);
//    }

    /**
     * Overwrites the default footer
     * set the text in the view using
     * $fpdf->xfootertext = 'Copyright Â© %d YOUR ORGANIZATION. All rights reserved.';
     */
    function Footer() {
        $year = date('Y');
        $footertext = sprintf($this->xfootertext, $year);
        $this->SetY(-20);
        $this->SetTextColor(0, 0, 0);
        $this->SetFont($this->xfooterfont, '', $this->xfooterfontsize);
        $this->Cell(0, 8, $footertext, 'T', 1, 'C');
    }

}

?>