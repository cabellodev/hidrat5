<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct(){
		parent:: __construct(); 
	}
	
	//Funcion para cargar la vista del login
    public function login()
	{
		$this->load->view('login');
	}

	//Funcion para redirigir a los usuarios logeados segun privilegios
	public function load_page()
	{
		/*Verificar que el usuario esta logeado*/
		if ($this->accesscontrol->checkAuth()['correct']) {
			$rango = $this->session->rango;

			if($this->session->usuario == "user"){
				//SuperAdmin
				if ($rango == 1) $this->load_page_role("SuperAdmin", "admin");
				//Admin
				else if ($rango == 2) $this->load_page_role("Admin","admin");
				//técnico master
				else if ($rango == 3) $this->load_page_role("TechnicalMaster","TechnicalMaster");
				//ayudante técnico
				else if ($rango == 4) $this->load_page_role("TechnicalAssistant", "TechnicalAssistant");
				//vendedor
				else if ($rango == 5) $this->load_page_role("Seller", "seller");
			}else if($this->session->usuario == "client"){
				//Client Read
				if ($rango == 1) $this->load_page_role("ClientRead", "client");
				//Client Edit
				else if ($rango == 2){
					$this->load_page_role("ClientEdit", "client");
				} 
			}else{
				redirect(base_url() . 'Home/login', 'refresh');
			}
        } else {
			redirect('Home/login', 'refresh');
        }
	}

	public function load_page_role($path, $folderView)
	{
		$this->load->view('shared/header'.$path);
		$this->load->view($folderView.'/counterOrders');
		$this->load->view('shared/footer');
	}

	public function error()
	{
		$this->load->view('shared/error');
	}
	
	
}
