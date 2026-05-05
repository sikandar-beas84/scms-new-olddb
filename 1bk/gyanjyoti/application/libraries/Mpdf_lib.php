<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mpdf_lib {
    public $mpdf;

    public function __construct($params = []) {
        require_once APPPATH . 'libraries/mpdf/autoload.php';

        // Set default options
        $defaultConfig = [
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
            'default_font_size' => 12
        ];

        // Merge user options with default options
        $config = array_merge($defaultConfig, $params);

        // Initialize mPDF
        $this->mpdf = new \Mpdf\Mpdf($config);
    }

    public function loadHtml($html) {
        $this->mpdf->WriteHTML($html);
    }

    public function output($filename = 'document.pdf', $dest = 'I') {
        return $this->mpdf->Output($filename, $dest);
    }
}
