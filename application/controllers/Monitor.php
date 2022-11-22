<?php


defined('BASEPATH') or exit('No direct script access allowed');
class Monitor extends CI_Controller {

public function __construct(){
    parent:: __construct(); 
}

   public function viewProjector()

    { 
    
        if ($this->accesscontrol->checkAuth()['correct'] || !$this->accesscontrol->checkAuth()['correct']) {
 
            $this->load->view('admin/projector');
 
        } 
    }


    public function projector_external()

    { 

        if ($this->accesscontrol->checkAuth()['correct'] || !$this->accesscontrol->checkAuth()['correct']) {
            $this->load->view('admin/projector');
        }
    }




    public function chartQuotation(){

        if ($this->accesscontrol->checkAuth()['correct'] || !$this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('ProjectorModel');
            $datos = $this->ProjectorModel->getKpiQuotation();
            $this->response->sendJSONResponse($datos);

        } 
    }


    public function chartProduction(){
        
        if ($this->accesscontrol->checkAuth()['correct'] || !$this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('ProjectorModel');
            $datos = $this->ProjectorModel->getKpiProduction();
            $this->response->sendJSONResponse($datos);
        }
    }

    public function getOrders(){
        
        if ($this->accesscontrol->checkAuth()['correct'] || !$this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('ProjectorModel');
            $orders = $this->ProjectorModel->getOrders();
       
            $this->response->sendJSONResponse($orders);
        } 
    }



    public function getQuotation(){
        
        if ($this->accesscontrol->checkAuth()['correct'] || !$this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('ProjectorModel');
            $orders = $this->ProjectorModel->getQuotation();
       
            $this->response->sendJSONResponse($orders);
        } 
    }



}
