<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


include APPPATH . '/third_party/fpdf/fpdf.php';

class Fpdf_lib extends FPDF
{

    private $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

}

