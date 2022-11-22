<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Seller extends CI_Controller
{


    public function ordersApproved()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->view('shared/headerSeller');
            $this->load->view('seller/orderApproved');
            $this->load->view('shared/footer');
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    public function ordersWapprobation()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->view('shared/headerSeller');
            $this->load->view('seller/ordersWapprobation');
            $this->load->view('shared/footer');
        } else {
            redirect('Home/login', 'refresh');
        }
    }
    
   public function adminClients(){
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->view('shared/headerSeller');
            $this->load->view('seller/adminClients');
            $this->load->view('shared/footer');
        } else {
            redirect('Home/login', 'refresh');
        }

    }


    public function  stagesOrderSeller()
    { 
        if ($this->accesscontrol->checkAuth()['correct']) {
            $url = parse_url($_SERVER['REQUEST_URI']);
            parse_str($url['query'], $params);
            $id = $params['ot'];
            $this->load->model('Orders_model');
            $order = $this->Orders_model->getOrder($id);
            $order['states'] = $this->Orders_model->getStates();
            $this->load->view('shared/headerSeller');
            $this->load->view('seller/stagesOrder', $order);
            $this->load->view('shared/footer');
        } else {
            redirect('Home/login', 'refresh');
        }
    }

   

  

    public function  ordersEnterprise() { 
       
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('SellerModel');
            $data = $this->input->post('data');
         if($res=$this->SellerModel->ordersEnterprise($data)){
             $this->response->sendJSONResponse($res); 
           }else{
             $this->response->sendJSONResponse(array('msg' => 'No se ha podido obtener los datos.'), 400); 
           }
           }else{
             $this->response->sendJSONResponse(array('msg' => 'No tiene permisos suficientes.'), 400);
           }
    }


    public function  ordersAllEnterprise() { 
       
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('SellerModel');
         if($res=$this->SellerModel->orderAllEnterprise ()){
             $this->response->sendJSONResponse($res); 
           }else{
             $this->response->sendJSONResponse(array('msg' => 'No se ha podido obtener los datos.'), 400); 
           }
           }else{
             $this->response->sendJSONResponse(array('msg' => 'No tiene permisos suficientes.'), 400);
           }
    }


    public function  getApproveTechnicalReport() { 
       
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('SellerModel');
         if($res=$this->SellerModel->getApproveTechnicalReport()){
             $this->response->sendJSONResponse($res); 
           }else{
             $this->response->sendJSONResponse(array('msg' => 'No se ha podido obtener los datos.'), 400); 
           }
           }else{
             $this->response->sendJSONResponse(array('msg' => 'No tiene permisos suficientes.'), 400);
           }
    }
    
    public function getOrdersQuotation() { 
      
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('SellerModel');
         if($res=$this->SellerModel->getOrdersQuotation()){
             $this->response->sendJSONResponse($res); 
           }else{
             $this->response->sendJSONResponse(array('msg' => 'Esta orden no tiene configurada una evaluación.'), 400); 
           }
           }else{
             $this->response->sendJSONResponse(array('msg' => 'No tiene permisos suficientes.'), 400);
           }
    }

    public function changeState()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			$this->load->model('SellerModel');
			$data = $this->input->post('data');
			$state = $data['approve'];
			$id = $data['id'];
            $states=$data['states'];
			$res = $this->SellerModel->changeState($id, $state,$states);
			if ($res) {
				$this->response->sendJSONResponse(array('msg' => "Estado cambiado exitosamente."));
			} else {
				$this->response->sendJSONResponse(array('msg' => "No se pudo cambiar el estado."), 400);
			}
		} else {
			$this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
		}
	}

    
    public function editOC ($id) {
        
        $config['upload_path'] = "./assets/upload/purshaseOrder";
        $config['allowed_types'] = '*';
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload("oc")) {
            $data = array('upload_data' => $this->upload->data());
            $pdf = $data['upload_data']['file_name'];
            $array = explode(".", $pdf); //divide string y convierte en array 
            $formato =  $array[1];// selecciona el indice 1 igual a pdf 
            if($formato == "pdf") {
            $this->load->model('AprobationModel');
                 if ( $res = $this->AprobationModel->uploadOC($id, $pdf)) {
                     $this->response->sendJSONResponse(array('msg' => "Archivo subido con éxito."));
                     } else {
                       $this->response->sendJSONResponse(array('msg' => "error"), 500);
                      }
            }else { $this->response->sendJSONResponse(array('msg' => "Cargue un formato correcto por favor"), 500); } 
        } else {
            $this->response->sendJSONResponse(array(
                "msg" => "error",
                "id" => $id, "i" => $this->upload->display_errors(),
                "c" => $config['upload_path']
            ));
        }

    }



}
