<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once 'dompdf/dompdf_config.inc.php';

class Dompdflib
{

    public $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function generate($view, $fileName, $orientation = 'landscape')
    {
        $dompdfx = new DOMPDF();
        $dompdfx->set_paper('A4', $orientation);
        $dompdfx->load_html($view);
        $dompdfx->render();
        $dompdfx->stream($fileName);
    }
}
