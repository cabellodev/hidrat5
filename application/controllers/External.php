<?php
defined('BASEPATH') or exit('No direct script access allowed');

class External extends CI_Controller {

	public function __construct(){
		parent:: __construct(); 
		$this->load->model('ExternalModel');
	}
	
	//Funcion para cargar la vista del login
    public function index()
	{
        $this->ExternalModel->generateMensualKpi();            
	}
}
