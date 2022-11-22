<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Controller {

	public function __construct(){
		parent:: __construct(); 
		$this->load->model('Client_model');
		$this->load->helper('client_rules');
	}
	
	//Funcion para cargar la vista del login
	public function index()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {

			$rango = $_SESSION['rango'];
            if($rango == 1){
			$this->load->view('shared/headerSuperAdmin');
			$this->load->view('admin/admin_client');
			$this->load->view('shared/footer');
			}else if($rango == 2){
			$this->load->view('shared/headerAdmin');
			$this->load->view('admin/admin_client');
			$this->load->view('shared/footer');
			}
        } else {
			redirect('Home/login', 'refresh');
        }
	}


	//Funcion para listar usuario
	public function list()
	{
		$clients = $this->Client_model->get_clients();
        $roles = $this->Client_model->get_roles();
        $enterprises = $this->Client_model->get_enterprises();
		$sellers = $this->Client_model->get_sellers();
        $this->response->sendJSONResponse(array($clients, $roles, $enterprises, $sellers));
	}

	//Funcion para crear un usuario
	public function create()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			/* Datos de formulario*/
			$data = $this->input->post('data'); 

			/* Cargar datos para la validación de formulario*/
			$rules = get_rules_client_create();
			$this->form_validation->set_error_delimiters('', '');
			$this->form_validation->set_data($data);
			$this->form_validation->set_rules($rules);
	
			/*Validación de formulario
			Si el formulario no es valido*/
			if($this->form_validation->run() == FALSE){
				if(form_error('full_name')) $msg['full_name'] = form_error('full_name');
				if(form_error('passwd')) $msg['passwd'] = form_error('passwd');
				if(form_error('email')) $msg['email'] = form_error('email');
				if(form_error('range')) $msg['range'] = form_error('range');
				if(form_error('enterprise')) $msg['enterprise'] = form_error('enterprise');
				if(form_error('seller')) $msg['seller'] = form_error('seller');
				$this->response->sendJSONResponse($msg);
				$this->output->set_status_header(400); 
			}else{
			/*Si el formulario es valido*/
				/*Crear usuario*/
				if($id = $this->Client_model->create($data)){
					/*Actualizar registro en la tabla roles */
					if($res = $this->Client_model->create_rol($data, $id)){
						$msg['msg'] = "Cliente registrado con éxito.";
						$this->response->sendJSONResponse($msg);
					}else{
						$msg['msg'] = "No se pudo cargar el recurso";
						$this->response->sendJSONResponse($msg);
						$this->output->set_status_header(405);
					}
				}else{
					$msg['msg'] = "El cliente ya se encuentra registrado.";
					$this->response->sendJSONResponse($msg);
					$this->output->set_status_header(405);
				} 	
			}     
        } else {
			redirect('Home/login', 'refresh');
        }
    }    

	//Funcion para editar un usuario
	public function update()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			/* Datos de formulario*/
		$data = $this->input->post('data'); 
		/* Cargar datos para la validación de formulario*/
		$rules = get_rules_client_edit();
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_data($data);
		$this->form_validation->set_rules($rules);

		/*Validación de formulario
		Si el formulario no es valido*/
		if($this->form_validation->run() == FALSE){
			if(form_error('full_name')) $msg['full_name'] = form_error('full_name');
			if(form_error('email')) $msg['email'] = form_error('email');
            if(form_error('range')) $msg['range'] = form_error('range');
            if(form_error('enterprise')) $msg['enterprise'] = form_error('enterprise');
			$this->response->sendJSONResponse($msg);
			$this->output->set_status_header(400); 
		}else{
		/*Si el formulario es valido*/
			if($id  = $this->Client_model->update($data)){
				/*Actualizar registro en la tabla roles */
				if($res = $this->Client_model->update_rol($data, $id)){
					$msg['msg'] = "Cliente actualizado con éxito.";
					$this->response->sendJSONResponse($msg);
				}else{
					$msg['msg'] = "No se pudo cargar el recurso";
					$this->response->sendJSONResponse($msg);
					$this->output->set_status_header(405);
				}
			}else{
				$msg['msg'] = "El cliente ya se encuentra registrado.";
				$this->response->sendJSONResponse($msg);
				$this->output->set_status_header(405);
			} 	
		} 
        } else {
			redirect('Home/login', 'refresh');
        }
	}

	//Funcion para deshabilitar y habilitar un usuario
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
			if($this->Client_model->des_hab($data)){
				$msg['msg'] = "El usuario ha sido ".$hab_des." con éxito";
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
