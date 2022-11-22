<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Techinformation extends CI_Controller
{

    public function __construct(){
		parent:: __construct(); 
		
	}

    public function viewInfoTech()
    {     
        if ($this->accesscontrol->checkAuth()['correct']) {
            $user =$_SESSION['rango'];
            if($user == 1 ){
            $this->load->view('shared/headerSuperAdmin');
            $this->load->view('admin/informationTechnical');
            $this->load->view('shared/footer');
            }else if ($user == 2){
                $this->load->view('shared/headerAdmin');
                $this->load->view('admin/informationTechnical');
                $this->load->view('shared/footer');
            }
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    public function getTechnical(){
           
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('TechinformationModel');
            if($data= $this->TechinformationModel->getTechnical()){
                $this->response->sendJSONResponse(array($data));
            }else {
                $this->response->sendJSONResponse(array('msg' => 'No se ha podido cargar la información'), 400);
            }
            
        } else {
            redirect('Home/login', 'refresh');
        }
        

    }
    public function selectTech(){
        if ($this->accesscontrol->checkAuth()['correct']) {
            $technical =  $this->input->post('data');
            $this->load->model('TechinformationModel');
            if($data= $this->TechinformationModel-> selectTech($technical['technical'])){
                $this->response->sendJSONResponse(array($data));
            }else {
                $this->response->sendJSONResponse(array('msg' => 'No se ha podido cargar la información'), 400);
            }
            
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    public function getAssistent(){
           
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('TechinformationModel');
            if($data= $this->TechinformationModel->getAssistent()){
                $this->response->sendJSONResponse(array($data));
            }else {
                $this->response->sendJSONResponse(array('msg' => 'No se ha podido cargar la información'), 400);
            }
            
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    public function getOrdersWorked(){
           
        if ($this->accesscontrol->checkAuth()['correct']) {
            $user =  $this->input->post('data');
            $this->load->model('TechinformationModel');
            if($data= $this->TechinformationModel-> getOrdersWorked($user['user'])){
                $this->response->sendJSONResponse(array($data));
            }else {
                $this->response->sendJSONResponse(array('msg' => 'No se ha podido cargar la información'), 400);
            }
            
        } else {
            redirect('Home/login', 'refresh');
        }
    }

   public function getOrdersWorkedAT(){

          if ($this->accesscontrol->checkAuth()['correct']) {
              $data =  $this->input->post('data');
              $this->load->model('TechinformationModel');
              if($data= $this->TechinformationModel-> getOrdersWorkedAT($data)){
                  $this->response->sendJSONResponse(array($data));
              }else {
                  $this->response->sendJSONResponse(array('msg' => 'No se ha podido cargar la información'), 400);
              }

          } else {
              redirect('Home/login', 'refresh');
          }
      }
  
    public function getInfoEvaluation(){

          if ($this->accesscontrol->checkAuth()['correct']) {
              $data =  $this->input->post('data');
              $this->load->model('TechinformationModel');
              if($res= $this->TechinformationModel-> getInfoEvaluation($data['ot_number'])){
                  $this->response->sendJSONResponse($res);
              }else {
                  $this->response->sendJSONResponse(array('msg' => 'No se ha podido cargar la información'), 400);
              }

          } else {
              redirect('Home/login', 'refresh');
          }
      }


    public function getInfoRep(){
           
        if ($this->accesscontrol->checkAuth()['correct']) {
            $data =  $this->input->post('data');
            $this->load->model('TechinformationModel');
            if($res= $this->TechinformationModel-> getInfoRep($data['ot_number'])){
                $this->response->sendJSONResponse($res);
            }else {
                $this->response->sendJSONResponse(array('msg' => 'No se ha podido cargar la información'), 400);
            }
            
        } else {
            redirect('Home/login', 'refresh');
        }
        

    }


    public function getInfoTr(){
           
        if ($this->accesscontrol->checkAuth()['correct']) {
            $data =  $this->input->post('data');
            $this->load->model('TechinformationModel');
            if($res= $this->TechinformationModel-> getInfoTr($data['ot_number'])){
                $this->response->sendJSONResponse($res);
            }else {
                $this->response->sendJSONResponse(array('msg' => 'No se ha podido cargar la información'), 400);
            }
            
        } else {
            redirect('Home/login', 'refresh');
        }
        

    }

    public function getInfoHt(){
           
        if ($this->accesscontrol->checkAuth()['correct']) {
            $data =  $this->input->post('data');
            $this->load->model('TechinformationModel');
            if($res= $this->TechinformationModel-> getInfoHt($data['ot_number'])){
                $this->response->sendJSONResponse($res);
            }else {
                $this->response->sendJSONResponse(array('msg' => 'No se ha podido cargar la información'), 400);
            }
            
        } else {
            redirect('Home/login', 'refresh');
        }
        

    }

}