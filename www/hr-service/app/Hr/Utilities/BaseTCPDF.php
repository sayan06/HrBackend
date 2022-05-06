<?php

namespace App\Hr\Utilities;

use TCPDF;

class BaseTCPDF extends TCPDF
{
    public function Header()
    {
        $this->SetFont('helvetica', 'B', 20);
        $this->Cell(0, 15, 'IMS BARCODES', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}
