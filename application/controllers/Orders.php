<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Orders extends CI_Controller
{
    public function __construct(){
		parent:: __construct(); 
		$this->load->model('Orders_model');
        $this->load->helper('ot_rules');
        $this->load->library('Fpdf_lib');
	}

    public function adminOrders()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $user =$_SESSION['rango'];
            if($user == 1 ){
            $this->load->view('shared/headerSuperAdmin');
            $this->load->view('admin/adminOrders');
            $this->load->view('shared/footer');
            }else if($user == 2){
           
           
            $this->load->view('shared/headerAdmin');
            $this->load->view('admin/adminOrders');
            $this->load->view('shared/footer');
            }

            
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    public function newOrder()
    { 
        if ($this->accesscontrol->checkAuth()['correct']) {
            $user =$_SESSION['rango'];
            if($user == 1 ){

            $this->load->view('shared/headerSuperAdmin');
            $this->load->view('admin/registerOrder');
            $this->load->view('shared/footer');

            }else if($user == 2){

            $this->load->view('shared/headerAdmin');
            $this->load->view('admin/registerOrder');
            $this->load->view('shared/footer');
            }
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    public function createOrder()
    { 
        if ($this->accesscontrol->checkAuth()['correct']) {
			/* Datos de formulario*/
			$data = $this->input->post('data');
            $ot_number = $data['ot_number'];
            $id_technical = $data['technical'];
            $id_technical_tr = $data['technical_tr'];
            $check_evaluation = $data['check_evaluation'];
            $check_report_technical = $data['check_report_technical'];
            $check_hydraulic_test = $data['check_hydraulic_test'];

			/* Cargar datos para la validación de formulario*/
			$rules = get_rules_ot_create();
			$this->form_validation->set_error_delimiters('', '');
			$this->form_validation->set_data($data);
			$this->form_validation->set_rules($rules);
	
			/*Validación de formulario
			Si el formulario no es valido*/
			if($this->form_validation->run() == FALSE){
				if(form_error('ot_number')) $msg['ot_number'] = form_error('ot_number');
                if(form_error('enterprise')) $msg['enterprise'] = form_error('enterprise');
                if(form_error('service')) $msg['service'] = form_error('service');
                if(form_error('component')) $msg['component'] = form_error('component');
                if(form_error('priority')) $msg['priority'] = form_error('priority');
                if(form_error('date_admission')) $msg['date_admission'] = form_error('date_admission');
                if(form_error('days_quotation')) $msg['days_quotation'] = form_error('days_quotation');
				$this->response->sendJSONResponse($msg);
				$this->output->set_status_header(400); 
			}else{
			/*Si el formulario es valido*/
				/*Crear ot*/
                /*Ingresada correctamente*/
                $id = $_SESSION['id'];
                if($this->Orders_model->createOrder($data, $id)){
				/*Crear los informes de ser necesario*/
                    if($check_evaluation == 'true'){
                        if($data['technical']){
                            $this->Orders_model->createEvaluation($ot_number, $id_technical);
                        }else{
                            $this->Orders_model->createEvaluation($ot_number, null);
                        }
                    }

                    if($check_report_technical == 'true'){

                        if($data['technical_tr']){
                            $this->Orders_model->createTechnicalReport($ot_number, $id_technical_tr);
                        }else{
                            $this->Orders_model->createTechnicalReport($ot_number, null);
                        }                      
                    }

                    if($check_hydraulic_test == 'true'){
                        $this->Orders_model->createHydraulicTest($ot_number);
                    }

                    $this->Orders_model->createAprobation($data);
                    $msg['msg'] = "OT registrado con éxito.";
                    $this->response->sendJSONResponse($msg);
                /*Fallo en el ingreso */
				}else{
					$msg['msg'] = "La OT ya se encuentra registrada.";
					$this->response->sendJSONResponse($msg);
					$this->output->set_status_header(405);
				} 	
			}     
        } else {
			redirect('Home/login', 'refresh');
        }
    }

    public function getOrders()
    { 
		$orders = $this->Orders_model->getOrders();
        $this->response->sendJSONResponse($orders);
    }

    public function getLocations()
    { 
		$locations = $this->Orders_model->getLocations();
        $this->response->sendJSONResponse($locations);
    }

    public function getOrdersTest()
    { 
		$orders = $this->Orders_model->getOrdersTest();
        $this->response->sendJSONResponse($orders);
    }

    public function getFieldsOrder()
    { 
        $components = $this->Orders_model->getComponents();
        $enterprises = $this->Orders_model->getEnterprises();
		$technicals = $this->Orders_model->getTechnicals();
        $locations = $this->Orders_model->getLocations();
        $this->response->sendJSONResponse(array($components, $enterprises, $technicals, $locations));
    }

    public function stagesOrder()
    { 
        if ($this->accesscontrol->checkAuth()['correct']) {
            $url = parse_url($_SERVER['REQUEST_URI']);
            parse_str($url['query'], $params);
            $id = $params['ot'];
            $user =$_SESSION['rango'];
               if($this->Orders_model->exist_ot_number($id)){
                      $order = $this->Orders_model->getOrder($id);
                      $order['states'] = $this->Orders_model->getStates();
                             if($user == 1){
                                    $this->load->view('shared/headerSuperAdmin');
                             }else if ($user == 2){
                                    $this->load->view('shared/headerAdmin');
                              }
                                    $this->load->view('admin/stagesOrder', $order);
                                    $this->load->view('shared/footer');
               }else{

                              if($user == 1){
                                     $this->load->view('shared/headerSuperAdmin');
                              }else if ($user == 2){
                                     $this->load->view('shared/headerAdmin');
                               }
                            
                               $this->load->view('admin/adminOrders');
                               $this->load->view('shared/footer');

               }
        } else {
            redirect('Home/login', 'refresh');
        }
    }



    public function autoincrementID()
    { 
		$id= $this->Orders_model->autoincrementID();
        
        $this->response->sendJSONResponse($id);
    }
    
  
    

    public function newUpdateOrder()
    { 
        if ($this->accesscontrol->checkAuth()['correct']) {
            $url = parse_url($_SERVER['REQUEST_URI']);
            parse_str($url['query'], $params);
            $id = $params['ot'];
            $user =$_SESSION['rango'];
            if($this->Orders_model->exist_ot_number($id)){

                    $order = $this->Orders_model->getOrder($id);
                    $order['states'] = $this->Orders_model->getStates();
                    $order['components'] = $this->Orders_model->getComponents();
                    $order['enterprises'] = $this->Orders_model->getEnterprises();
                    $order['technicals'] = $this->Orders_model->getTechnicals();
                    $order['locations'] = $this->Orders_model->getLocations();
                    $order['config'] = json_decode($order['config'], true);
           
                    if($user == 1){
                      $this->load->view('shared/headerSuperAdmin');
                    }else if ($user == 2){
                      $this->load->view('shared/headerAdmin');
                    }
                    $this->load->view('admin/updateOrder', $order);
                    $this->load->view('shared/footer');

             }else{
                    if($user == 1){
                        $this->load->view('shared/headerSuperAdmin');
                     }else if ($user == 2){
                         $this->load->view('shared/headerAdmin');
                     }
                     $this->load->view('admin/adminOrders');
                     $this->load->view('shared/footer');
             }
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    public function updateOrder()
    {
        if ($this->accesscontrol->checkAuth()['correct']) {
			/* Datos de formulario*/
			$data = $this->input->post('data');
            $check_evaluation = $data['check_evaluation'];
            $check_report_technical = $data['check_report_technical'];
            $check_hydraulic_test = $data['check_hydraulic_test'];
            $check_evaluation_old = $data['check_evaluation_old'];
            $check_report_technical_old = $data['check_report_technical_old'];
            $check_hydraulic_test_old = $data['check_hydraulic_test_old'];
           
            /* Cargar datos para la validación de formulario*/
			$rules = get_rules_ot_create();
			$this->form_validation->set_error_delimiters('', '');
			$this->form_validation->set_data($data);
			$this->form_validation->set_rules($rules);
	
			/*Validación de formulario
			Si el formulario no es valido*/
			if($this->form_validation->run() == FALSE){
				if(form_error('ot_number')) $msg['ot_number'] = form_error('ot_number');
                if(form_error('enterprise')) $msg['enterprise'] = form_error('enterprise');
                if(form_error('service')) $msg['service'] = form_error('service');
                if(form_error('component')) $msg['component'] = form_error('component');
                if(form_error('priority')) $msg['priority'] = form_error('priority');
                if(form_error('date_admission')) $msg['date_admission'] = form_error('date_admission');
                if(form_error('days_quotation')) $msg['days_quotation'] = form_error('days_quotation');
				$this->response->sendJSONResponse($msg);
				$this->output->set_status_header(400); 
			}else{
			/*Si el formulario es valido*/
				/*Editar ot*/
                /*Ingresada correctamente*/
                $id = $_SESSION['id'];
                $name = $_SESSION['full_name'];
                date_default_timezone_set("America/Santiago");
                $date = date("Y-m-d G:i:s");
                if($this->Orders_model->updateOrder($data, $id)){
				/*Actualizar los informes de ser necesario*/
                    if($check_evaluation != $check_evaluation_old){
                        if($check_evaluation == 'true'){
                            $this->Orders_model->createEvaluation($data['ot_number'], null);
                        }else{
                            $this->Orders_model->desEvaluation($data['ot_number']);
                        }
                    }

                    if($check_report_technical != $check_report_technical_old){
                        if($check_report_technical == 'true'){
                            $this->Orders_model->createTechnicalReport($data['ot_number'], null);
                        }else{
                            $this->Orders_model->desTechnicalReport($data['ot_number']);
                        }
                    }

                    if($check_hydraulic_test != $check_hydraulic_test_old){
                        if($check_hydraulic_test == 'true'){
                            $this->Orders_model->createHydraulicTest($data['ot_number']);
                        }else{
                            $this->Orders_model->desHydraulicTest($data['ot_number']);
                        }
                    }

                    /* Actualizar fecha limite de cotización*/
                    $this->Orders_model->updateApprobation($data);

                    $msg['msg'] = "OT actualizada con éxito.";
                    $this->response->sendJSONResponse($msg);
                /*Fallo en el ingreso */
				}else{
					$msg['msg'] = "El número de OT al cual se quiere actualizar ya se encuentra registrado.";
					$this->response->sendJSONResponse($msg);
					$this->output->set_status_header(405);
				} 	
			}     
			
        } else {
			redirect('Home/login', 'refresh');
        }
    }
    
    public function changeStateOrder()
    { 
        if ($this->accesscontrol->checkAuth()['correct']) {
            $data = $this->input->post('data');
            $id = $_SESSION['id'];
            if($this->Orders_model->changeStateOrder($data, $id)){
            /*Crear los informes de ser necesario*/
                $msg['msg'] = "Estado cambiado con éxito.";
                $this->response->sendJSONResponse($msg);
            }	
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    public function changeLocationOrder()
    { 
        if ($this->accesscontrol->checkAuth()['correct']) {
            $data = $this->input->post('data');
            $id = $_SESSION['id'];
            if($this->Orders_model->changeLocationOrder($data, $id)){
                $msg['msg'] = "Estado cambiado con éxito.";
                $this->response->sendJSONResponse($msg);
            }	
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    public function getHistoryStatesByOrder($id)
    {
        if ($this->accesscontrol->checkAuth()['correct']) {
            if($history = $this->Orders_model->getHistoryStatesByOrder($id)){
                $this->response->sendJSONResponse($history); 
            }else{
                $msg['msg'] = "Error al obtener los estados asociados a la órden de trabajo";
                $this->response->sendJSONResponse($msg);
                $this->output->set_status_header(405);
            } 
        } else {
            redirect('Home/login', 'refresh');
        }
    }
}

