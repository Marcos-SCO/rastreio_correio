<?php

namespace App\Classes;

use Mpdf\Mpdf;

class Pdf
{
    public $mpdf;

    public function __construct()
    {
        $this->mpdf = new Mpdf();
    }

    public function loadHTML($body)
    {
        $this->mpdf->WriteHTML($body);
        return $this->mpdf->Output();
    }
}

