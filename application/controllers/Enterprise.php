<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enterprise extends CI_Controller {

	public function __construct(){
		parent:: __construct(); 
		$this->load->model('Enterprise_model');
		$this->load->helper('enterprise_rules');
	}
	
	//Funcion para cargar la vista del login
    public function index()
	{
        if ($this->accesscontrol->checkAuth()['correct']) {
            $rango = $_SESSION['rango'];
            if($rango == 1){
                
            $this->load->view('shared/headerSuperAdmin');
            $this->load->view('admin/admin_enterprise');
            $this->load->view('shared/footer');

            }else if($rango == 2){ 

            $this->load->view('shared/headerAdmin');
            $this->load->view('admin/admin_enterprise');
            $this->load->view('shared/footer');

            }
        } else {
			redirect('Home/login', 'refresh');
        }
	}
	//Funcion para listar las empresas
	public function list()
	{
        $data = $this->Enterprise_model->get_enterprises();
        $this->response->sendJSONResponse($data);
	}

	//Funcion para crear una empresa
	public function create()
	{
        if ($this->accesscontrol->checkAuth()['correct']) {
              /* Datos de formulario*/
        $data = $this->input->post('data'); 
        $data['state']= 1;

        /* Cargar datos para la validación de formulario*/
        $rules = get_rules_enterprise();
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($data);
        $this->form_validation->set_rules($rules);

            /*Validación de formulario
            Si el formulario no es valido*/
            if($this->form_validation->run() == FALSE){
                if(form_error('rut')) $msg['rut'] = form_error('rut');
                if(form_error('name')) $msg['name'] = form_error('name');
                $this->response->sendJSONResponse($msg);
                $this->output->set_status_header(400); 
            }else{
            /*Si el formulario es valido*/
                /*Crear empresa*/ 
                if($res = $this->Enterprise_model->create($data)){
                    $msg['msg'] = "Empresa registrada con éxito.";
                    $this->response->sendJSONResponse($msg);
                }else{
                    $msg['msg'] = "La empresa ya se encuentra registrada.";
                    $this->response->sendJSONResponse($msg);
                    $this->output->set_status_header(405);
                }
            }     
        } else {
            redirect('Home/login', 'refresh');
        }
    }      

	//Funcion para editar una empresa
	public function update()
	{
        if ($this->accesscontrol->checkAuth()['correct']) {
            /* Datos de formulario*/
        $data = $this->input->post('data'); 
        /* Cargar datos para la validación de formulario*/
        $rules = get_rules_enterprise();
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($data);
        $this->form_validation->set_rules($rules);

        /*Validación de formulario
        Si el formulario no es valido*/
        if($this->form_validation->run() == FALSE){
            if(form_error('rut')) $msg['rut'] = form_error('rut');
            if(form_error('name')) $msg['name'] = form_error('name');
            $this->response->sendJSONResponse($msg);
            $this->output->set_status_header(400); 
        }else{
        /*Si el formulario es valido*/
            /*editar empresa*/ 
            if($res = $this->Enterprise_model->update($data)){
                $msg['msg'] = "Empresa actualizada con éxito.";
                $this->response->sendJSONResponse($msg);
            }else{
                $msg['msg'] = "La empresa ya se encuentra registrada.";
                $this->response->sendJSONResponse($msg);
                $this->output->set_status_header(405);
            }
        }     
        } else {
            redirect('Home/login', 'refresh');
        }
	}

	//Funcion para deshabilitar y habilitar una empresa
	public function des_hab()
	{
        if ($this->accesscontrol->checkAuth()['correct']) {
            /* Datos de formulario*/
            $data = $this->input->post('data');
            $state = $data['state'];

            /* Variables a utilizar*/
            $hab_des=""; /*Mensaje dinamico de des/hab*/
            if($state == 0) {$hab_des ="Deshabilitada";} else{$hab_des ="Habilitada"; } 

            /*actualizar state de la empresa*/ 
            if($this->Enterprise_model->des_hab($data)){
                $msg['msg'] = "La empresa ha sido ".$hab_des." con éxito";
                $this->response->sendJSONResponse($msg);
            }else{
                $msg['msg'] = "No se pudo cargar el recurso.";
                $this->response->sendJSONResponse($msg);
            }
        } else {
            redirect('Home/login', 'refresh');
        }
	}
}
