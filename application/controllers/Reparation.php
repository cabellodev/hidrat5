<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reparation extends CI_Controller
{
    public function __construct(){
		parent:: __construct(); 
		$this->load->model('ReparationModel');
	}

    public function getReparationByOrder($ot_id)
    { 
        if ($this->accesscontrol->checkAuth()['correct']) {
            if($reparation=$this->ReparationModel->getReparationByOrder($ot_id)){
                $technicals = $this->ReparationModel->getTechnicals();
                $this->response->sendJSONResponse(array($reparation, $technicals)); 
            }else{
                $this->response->sendJSONResponse(array('msg' => 'No se pudo encontrar el recurso.'), 400); 
            }
        }else {
            redirect('Home/login', 'refresh');
        }
    }


    public function editReparation()
    { 
        if ($this->accesscontrol->checkAuth()['correct']) {
            /* Datos de formulario*/
			$data = $this->input->post('data');

            /*Update reparation*/
            /*Success*/
            $id = $_SESSION['id'];
            if($this->ReparationModel->editReparation($data)){
                $msg['msg'] = "Reparación actualizada con éxito.";
                $this->response->sendJSONResponse($msg);
            /*Fail */
            }else{
                $msg['msg'] = "No se pudo encontrar el recurso.";
                $this->response->sendJSONResponse($msg);
                $this->output->set_status_header(405);
            } 	
        }else {
            redirect('Home/login', 'refresh');
        }
    }

    public function calculateReparation(){
        if ($this->accesscontrol->checkAuth()['correct']) {
			$data = $this->input->post('data');
            $date = $this->ReparationModel->calculateReparation($data);
            $this->response->sendJSONResponse($date);	
        }else {
            redirect('Home/login', 'refresh');
        }
    }
}
