<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * dompdf
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package        dompdf
 */
function pdf_create($html, $filename='', $stream=TRUE) 
{
    require_once("dompdf/dompdf_config.inc.php");
    
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename.".pdf");
    } else {
        return $dompdf->output();
    }
}
?>