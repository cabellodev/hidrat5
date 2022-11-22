<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Counter extends CI_Controller
{
    public function counterOrders()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $rango = $_SESSION['rango'];
            if($rango == 1){

            $this->load->view('shared/headerSuperAdmin');
            $this->load->view('admin/counterOrders');
            $this->load->view('shared/footer');

            }else if($rango == 2){

            $this->load->view('shared/headerAdmin');
            $this->load->view('admin/counterOrders');
            $this->load->view('shared/footer');
            }
        } else {
            redirect('Home/login', 'refresh');
        }
    }
    
    

    public function counterSeller()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->view('shared/headerSeller');
            $this->load->view('seller/counterOrders');
            $this->load->view('shared/footer');
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    public function counterOrdersByClient()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $rango = $_SESSION['rango'];
            if($rango == 1){
                $this->load->view('shared/headerClientRead');
                $this->load->view('client/counterOrders');
                $this->load->view('shared/footer');
            }else if($rango == 2){
                $this->load->view('shared/headerClientEdit');
                $this->load->view('client/counterOrders');
                $this->load->view('shared/footer');
            }


        } else {
            redirect('Home/login', 'refresh');
        }
    }


    public function getData()
    {
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('CounterModel');
            $datos = $this->CounterModel->getDataCounter();
            $this->response->sendJSONResponse($datos);
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }

    public function getDataByClient()
    {
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('Clients/CounterModel');
            $datos = $this->CounterModel->getDataCounter();
            $this->response->sendJSONResponse($datos);
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }
}
