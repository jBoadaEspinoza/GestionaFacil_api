<?php
class PRINTER
{
    public static function load($orientation,$unit,$size){
    	require_once APPPATH. 'third_party/FPDF/fpdf.php';
        $fpdf = new FPDF($orientation,$unit,$size);
        return $fpdf;
    }
}