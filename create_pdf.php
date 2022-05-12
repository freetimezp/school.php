<?php

//https://github.com/mpdf/mpdf

require_once __DIR__ . '/mpdf/autoload.php';

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML('<h1>Hello world!</h1>');
$mpdf->Output();