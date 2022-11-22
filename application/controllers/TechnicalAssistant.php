<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TechnicalAssistant extends CI_Controller
{

    public function __construct(){
		parent:: __construct(); 
		$this->load->model('TechnicalAssistantModel');
	}

    public function adminSubstaksReparation()
    {     
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->view('shared/headerTechnicalAssistant');
            $this->load->view('TechnicalAssistant/substasksReparationList');
            $this->load->view('shared/footer');
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    public function adminSubstaksEvaluation()
    {     
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->view('shared/headerTechnicalAssistant');
            $this->load->view('TechnicalAssistant/substasksEvaluationList');
            $this->load->view('shared/footer');
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    public function getSubstaksReparation() { 
        if ($this->accesscontrol->checkAuth()['correct']) {
            if($res = $this->TechnicalAssistantModel->getSubstaksReparation()){
                $this->response->sendJSONResponse($res);
            }else{
                //No hay subtareas asociadas
                $res = false;
                $this->response->sendJSONResponse($res);
            }
        }else{
             $this->response->sendJSONResponse(array('msg' => 'No tiene permisos suficientes.'), 400);
        }
    }

    public function getSubstaksEvaluation() { 
        if ($this->accesscontrol->checkAuth()['correct']) {
            if($res = $this->TechnicalAssistantModel->getSubstaksEvaluation()){
                $this->response->sendJSONResponse($res);
            }else{
                //No hay subtareas asociadas
                $res = false;
                $this->response->sendJSONResponse($res);
            }
        }else{
             $this->response->sendJSONResponse(array('msg' => 'No tiene permisos suficientes.'), 400);
        }
    }

    public function approveSubstakReparation(){ 
        if ($this->accesscontrol->checkAuth()['correct']) {
            $data = $this->input->post('data');
            if($report=$this->TechnicalAssistantModel->approve($data)){
                $this->response->sendJSONResponse($report); 
            }else{
                $this->response->sendJSONResponse(array('msg' => 'No se pudo actualizar la reparación.'), 400); 
            }
        }else {
			redirect('Home/login', 'refresh');
        }
    }

    public function approveSubstakEvaluation(){ 
        if ($this->accesscontrol->checkAuth()['correct']) {
            $data = $this->input->post('data');
            if($report=$this->TechnicalAssistantModel->approve($data)){
                $this->response->sendJSONResponse($report); 
            }else{
                $this->response->sendJSONResponse(array('msg' => 'No se pudo actualizar la reparación.'), 400); 
            }
        }else {
			redirect('Home/login', 'refresh');
        }
    }

    public function getCounterData(){

        if ($this->accesscontrol->checkAuth()['correct']) {
            $assistant= $_SESSION['id'];
            if($report=$this->TechnicalAssistantModel->getCounterData($assistant)){
                $this->response->sendJSONResponse($report); 
            }else{
                $this->response->sendJSONResponse(array('msg' => 'No se pudo actualizar la reparación.'), 400); 
            }
        }else {
			redirect('Home/login', 'refresh');
        }

    }
    
}