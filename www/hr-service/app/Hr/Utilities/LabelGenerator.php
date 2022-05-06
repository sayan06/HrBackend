<?php

namespace App\Hr\Utilities;

final class LabelGenerator
{
    public function generateLabels(array $printCount = [], array $entityList = [], array $uniqueIds = [])
    {
        $pdf = new BaseTCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->setHeaderFont([PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN]);
        $pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->SetFont('helvetica', '', 10);
        $pdf->AddPage();

        $style = $this->getStyle();

        $x = 5;
        $y = 15;
        $x1 = 22;
        $y1 = 11;
        $horizontalGap = 70;
        $verticalGap = 20;
        $xAxisLimitLabel = 215;
        $yAxisLimitLabel  = 275;
        $xAxisLimitTag = 232;
        $yAxisLimitTag = 271;

        for ($k = 0; $k <= count($printCount) - 1; $k++) {
            for ($i = 1; $i <= $printCount[$k]; $i++) {
                $pdf->Text($x1, $y1, $entityList[$k]);
                $pdf->write1DBarcode($uniqueIds[$k], 'C39', $x, $y, 60, 15, 0.4, $style, 'N');

                $x = $x + $horizontalGap;
                $x1 = $x1 + $horizontalGap;

                if ($x1 === $xAxisLimitTag) {
                    $y1 = $y1 + $verticalGap;
                    $x1 = 22;
                }

                if ($x === $xAxisLimitLabel) {
                    $y = $y + $verticalGap;
                    $x = 5;
                }

                if ($y1 === $yAxisLimitTag) {
                    $x1 = 22;
                    $y1 = 11;
                }

                if ($y === $yAxisLimitLabel) {
                    $pdf->AddPage();
                    $x = 5;
                    $y = 15;
                }
            }
        }

        $pdf->Output('labels' . '.pdf', 'I');
    }

    private function getStyle()
    {
        $style = [];

        $style = [
            'position' => '',
            'align' => 'C',
            'stretch' => false,
            'fitwidth' => true,
            'cellfitalign' => '',
            'border' => true,
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'fgcolor' => [0, 0, 0],
            'bgcolor' => false,
            'text' => true,
            'font' => 'helvetica',
            'fontsize' => 4,
            'stretchtext' => 4
        ];

        return $style;
    }
}
