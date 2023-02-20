<?php
defined('BASEPATH') or exit('No direct script access allowed');

class OrdersClient extends CI_Controller
{
    public function __construct(){
		parent:: __construct(); 
		$this->load->model('Clients/OrdersModel');
        $this->load->helper('ot_rules');
        $this->load->library(array('Fpdf_lib', 'phpmailer_lib'));
	}

    public function adminOrders()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->view('shared/headerClientEdit');
            $this->load->view('client/adminOrders');
            $this->load->view('shared/footer');
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    public function adminOrdersView()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->view('shared/headerClientRead');
            $this->load->view('client/adminOrders');
            $this->load->view('shared/footer');
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    public function adminOrdersApprove()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->view('shared/headerClientEdit');
            $this->load->view('client/adminOrdersApprove');
            $this->load->view('shared/footer');
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    public function adminOrdersApproveView()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->view('shared/headerClientRead');
            $this->load->view('client/adminOrdersApproveView');
            $this->load->view('shared/footer');
        } else {
            redirect('Home/login', 'refresh');
        }
    }


    public function getOrders()
    { 
		$orders = $this->OrdersModel->getOrders();
        $cont = 0;
        foreach($orders as $value){
            if($value['tr_details']) {
                $a = json_decode($value['tr_details'], true);
                if($a["check_adm"] == "true"){
                    $value['tr_details'] = 1;
                }else{
                    $value['tr_details'] = 0;
                } 
            }else{
                $value['tr_details'] = 0;
            }
        
            if($value['ht_details']) {
                $b = json_decode($value['ht_details'], true);
                if($b["approve_admin"] == "true"){
                    $value['ht_details'] = 1;
                }else{
                    $value['ht_details'] = 0;
                }
            }else{
                $value['ht_details'] = 0;
            }      
            $orders[$cont] = $value;
            $cont++;
        }
        $this->response->sendJSONResponse($orders);
    }

    public function getOrdersApprove()
    {
		$orders = $this->OrdersModel->getOrdersApprove();
        $cont = 0;
        foreach($orders as $value){
            if($value['tr_details']) {
                $a = json_decode($value['tr_details'], true);
                if($a["check_adm"] == "true"){
                    $value['tr_details'] = 1;
                }else{
                    $value['tr_details'] = 0;
                } 
            }else{
                $value['tr_details'] = 0;
            }
            $orders[$cont] = $value;
            $cont++;
        }
        $this->response->sendJSONResponse($orders);
    }

    public function approve($id)
    {
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
            $this->load->model('OrdersModel');
                if ( $res = $this->OrdersModel->approve($id, $pdf)) {
                    $this->response->sendJSONResponse(array('msg' => "Archivo subido con éxito."));
                    $email_info = $this->OrdersModel->approveEmail($id);
                    $emails = $this->OrdersModel->getEmails($id);
                    $this->phpmailer_lib->send_approve($email_info, $pdf, $emails);
                } else {
                    $this->response->sendJSONResponse(array('msg' => "error"), 500);
                }
            }else { 
                unlink('assets/upload/purshaseOrder/'.$pdf);
                $this->response->sendJSONResponse(array('msg' => "Cargue un formato correcto por favor"), 500); 
            } 
        } else {
            $this->response->sendJSONResponse(array(
                "msg" => "error",
                "id" => $id, "i" => $this->upload->display_errors(),
                "c" => $config['upload_path']
            ));
        } 
    }
}

