<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TechnicalMaster extends CI_Controller
{

    public function __construct(){
		parent:: __construct(); 
		$this->load->model('TechnicalMasterModel');
        $this->load->helper('substask_rules');
	}


    public function counterMaster ()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->view('shared/headerTechnicalMaster');
            $this->load->view('technicalMaster/counterOrders');
            $this->load->view('shared/footer');
        } else {
            redirect('Home/login', 'refresh');
        }
    }


    public function  stagesOrderTechnicals()
    { 
        if ($this->accesscontrol->checkAuth()['correct']) {
            $url = parse_url($_SERVER['REQUEST_URI']);
            parse_str($url['query'], $params);
            $id = $params['ot'];
            $this->load->model('Orders_model');
            $order = $this->Orders_model->getOrder($id);
            $order['states'] = $this->Orders_model->getStates();
            $this->load->view('shared/headerTechnicalMaster');
            $this->load->view('technicalMaster/stagesOrder', $order);
            $this->load->view('shared/footer');
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    public function orderById($id) { 
       
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('TechnicalMasterModel');
         if($res=$this->TechnicalMasterModel->orderById($id)){
             $this->response->sendJSONResponse($res); 
           }else{
             $this->response->sendJSONResponse(array('msg' => 'No se ha podido obtener los datos.'), 400); 
           }
           }else{
             $this->response->sendJSONResponse(array('msg' => 'No tiene permisos suficientes.'), 400);
           }
    }


   

    public function adminHydraulicTest()
    {     
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->view('shared/headerTechnicalMaster');
            $this->load->view('TechnicalMaster/HydraulicTestList');
            $this->load->view('shared/footer');
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    public function adminEvaluation()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->view('shared/headerTechnicalMaster');
            $this->load->view('TechnicalMaster/evaluationList');
            $this->load->view('shared/footer');
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    public function adminSubstasksReparation()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $url = parse_url($_SERVER['REQUEST_URI']);
            parse_str($url['query'], $params);
            $order  = array('id' => $params['ot']);
            $this->load->view('shared/headerTechnicalMaster');
            $this->load->view('TechnicalMaster/substasksReparationList', $order);
            $this->load->view('shared/footer');
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    public function adminSubstasksEvaluation() // hecho 
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $url = parse_url($_SERVER['REQUEST_URI']);
            parse_str($url['query'], $params);
            $order  = array('id' => $params['ot']);
            $this->load->view('shared/headerTechnicalMaster');
            $this->load->view('TechnicalMaster/subtasksEvaluationList', $order);
            $this->load->view('shared/footer');
        } else {
            redirect('Home/login', 'refresh');
        }
    }


    public function hydraylicTestForm()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $url = parse_url($_SERVER['REQUEST_URI']);
            parse_str($url['query'], $params);
            $id = $params['ot'];
            $this->load->view('shared/headerTechnicalMaster');
            $this->load->view('TechnicalMaster/hydraulicTest.php',array ('id'=> $id));
            $this->load->view('shared/footer');
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    public function hydraylicTestFormView()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $url = parse_url($_SERVER['REQUEST_URI']);
            parse_str($url['query'], $params);
            $id = $params['ot'];
            $this->load->view('shared/headerTechnicalMaster');
            $this->load->view('TechnicalMaster/hydraulicTestView.php',array ('id'=> $id));
            $this->load->view('shared/footer');
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    public function  getHydraulicTestEnable() { 
       
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('TechnicalMasterModel');
         if($res=$this->TechnicalMasterModel->getHydraulicTestEnable()){
             $this->response->sendJSONResponse($res); 
           }else{
             $this->response->sendJSONResponse(array('msg' => 'No se ha podido obtener los datos.'), 400); 
           }
           }else{
             $this->response->sendJSONResponse(array('msg' => 'No tiene permisos suficientes.'), 400);
           }
    }

    public function  getEvaluationEnable() { 
       
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('TechnicalMasterModel');
         if($res=$this->TechnicalMasterModel->getEvaluationEnable()){
             $this->response->sendJSONResponse($res); 
           }else{
             $this->response->sendJSONResponse(array('msg' => 'No se ha podido obtener los datos.'), 400); 
           }
           }else{
             $this->response->sendJSONResponse(array('msg' => 'No tiene permisos suficientes.'), 400);
           }
    }


    public function editEvaluation()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $url = parse_url($_SERVER['REQUEST_URI']);
            parse_str($url['query'], $params);
            $id = $params['ot'];
            $this->load->view('shared/headerTechnicalMaster');
            $this->load->view('TechnicalMaster/evaluation.php',array ('id'=> $id));
        }else {
            redirect('Home/login', 'refresh');
        }
    }

    public function adminTechnicalReport()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->view('shared/headerTechnicalMaster');
            $this->load->view('TechnicalMaster/technicalReportList');
            $this->load->view('shared/footer');
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    public function getTechnicalReports() { 
        if ($this->accesscontrol->checkAuth()['correct']) {
            if($res=$this->TechnicalMasterModel->getTechnicalReports()){
                $this->response->sendJSONResponse($res); 
            }else{
                //No hay informes tecnicos asociados al tecnico master
                $this->response->sendJSONResponse(false); 
            }
        }else{
             $this->response->sendJSONResponse(array('msg' => 'No tiene permisos suficientes.'), 400);
        }
    }   

    public function adminViewTechnicalReport($number_ot)
    { 
        if ($this->accesscontrol->checkAuth()['correct']) {
            $order['number_ot'] = $number_ot;
            $this->load->view('shared/headerTechnicalMaster');
            $this->load->view('TechnicalMaster/technicalReport', $order);

            $this->load->view('shared/footer');
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    public function viewEvaluation()
    { 
        if ($this->accesscontrol->checkAuth()['correct']) {
            $url = parse_url($_SERVER['REQUEST_URI']);
            parse_str($url['query'], $params);
            $id = $params['ot'];
            $this->load->view('shared/headerTechnicalMaster');
            $this->load->view('TechnicalMaster/evaluationView.php',array ('id'=> $id));
        }else {
            redirect('Home/login', 'refresh');
        }
    }

    public function getSubstakByEvaluation()
    { 
        if ($this->accesscontrol->checkAuth()['correct']) {
            
            $data = $this->input->post('data'); 
            $id = $data['id'];
            $subs = $this->TechnicalMasterModel->getSubstakByEvaluation($id);
            $this->response->sendJSONResponse($subs); 
        }else {
			redirect('Home/login', 'refresh');
        }
    }

    public function getSubstakByReparation()
    { 
        if ($this->accesscontrol->checkAuth()['correct']) {
            $data = $this->input->post('data'); 
            $id = $data['id'];
            $subs = $this->TechnicalMasterModel->getSubstakByReparation($id);
            $this->response->sendJSONResponse($subs); 
        }else {
			redirect('Home/login', 'refresh');
        }
    }

    public function DetailsTechnicalReport($id)
    { 
        if ($this->accesscontrol->checkAuth()['correct']) {
            if($report=$this->TechnicalMasterModel->getTechnicalReportByOrder($id)){
                $this->response->sendJSONResponse($report); 
            }else{
                $this->response->sendJSONResponse(array('msg' => 'Esta orden no tiene configurado un reporte técnico.'), 400); 
            }
        }else {
			redirect('Home/login', 'refresh');
        }
    }

/*     public function EditTechnicalReport()
    { 
        if ($this->accesscontrol->checkAuth()['correct']) {
            if($report=$this->TechnicalMasterModel->getTechnicalReportByOrder($id)){
                $this->response->sendJSONResponse($report); 
            }else{
                $this->response->sendJSONResponse(array('msg' => 'Esta orden no tiene configurado un reporte técnico.'), 400); 
            }
        }else {
			redirect('Home/login', 'refresh');
        }
    } */

    public function adminReparation()
    { 
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->view('shared/headerTechnicalMaster');
            $this->load->view('TechnicalMaster/reparationList');

            $this->load->view('shared/footer');
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    public function  getReparations() { 
       
        if ($this->accesscontrol->checkAuth()['correct']) {
            if($res=$this->TechnicalMasterModel->getReparations()){
                $this->response->sendJSONResponse($res); 
            }else{
                //No hay reparaciones asociados al tecnico master
                $this->response->sendJSONResponse(false); 
            }
        }else{
             $this->response->sendJSONResponse(array('msg' => 'No tiene permisos suficientes.'), 400);
        }
    }

    public function approveReparation()
    { 
        if ($this->accesscontrol->checkAuth()['correct']) {
            $data = $this->input->post('data');
            if($report=$this->TechnicalMasterModel->approveReparation($data)){
                $this->response->sendJSONResponse($report); 
            }else{
                $this->response->sendJSONResponse(array('msg' => 'No se pudo actualizar la reparación.'), 400); 
            }
        }else {
			redirect('Home/login', 'refresh');
        }
    }

    public function getSubstaksReparation($id) { 
       
        if ($this->accesscontrol->checkAuth()['correct']) {
                $technical_assistans = $this->TechnicalMasterModel->getTechnicalAssistans();
                $substaks = $this->TechnicalMasterModel->getSubstaks();
                $stateRep = $this->TechnicalMasterModel->getStateReparation($id);
            if($res = $this->TechnicalMasterModel->getSubstaksReparation($id)){
                $this->response->sendJSONResponse(array($res, $technical_assistans, $substaks, $stateRep ));
            }else{
                //No hay subtareas asociadas
                $res = false;
                $this->response->sendJSONResponse(array($res, $technical_assistans, $substaks, $stateRep));
            }
        }else{
             $this->response->sendJSONResponse(array('msg' => 'No tiene permisos suficientes.'), 400);
        }
    }
    
    public function getSubstaksEvaluation($id) { 
       
        if ($this->accesscontrol->checkAuth()['correct']) {
                $technical_assistans = $this->TechnicalMasterModel->getTechnicalAssistans();
                $substaks = $this->TechnicalMasterModel->getSubstaks();
                $stateEv = $this->TechnicalMasterModel->getStateEvaluation($id);
            if($res = $this->TechnicalMasterModel->getSubstaksEvaluation($id)){
                $this->response->sendJSONResponse(array($res, $technical_assistans, $substaks, $stateEv));
            }else{
                //No hay subtareas asociadas
                $res = false;
                $this->response->sendJSONResponse(array($res, $technical_assistans, $substaks, $stateEv));
            }
        }else{
             $this->response->sendJSONResponse(array('msg' => 'No tiene permisos suficientes.'), 400);
        }
    }

    //Funcion para crear una subtarea de reparación
    public function createSubstakReparation()
    {
        if ($this->accesscontrol->checkAuth()['correct']) {
            /* Datos de formulario*/
        $data = $this->input->post('data'); 
        /* Cargar datos para la validación de formulario*/
        $rules = get_rules_substask_create();
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($data);
        $this->form_validation->set_rules($rules);

        /*Validación de formulario
        Si el formulario no es valido*/
        if($this->form_validation->run() == FALSE){
            if(form_error('date_assignment')) $msg['date'] = form_error('date_assignment');
            if(form_error('subtask_id')) $msg['substak'] = form_error('subtask_id');
            if(form_error('user_id')) $msg['ta'] = form_error('user_id');
            $this->response->sendJSONResponse($msg);
            $this->output->set_status_header(400); 
        }else{
        /*Si el formulario es valido*/
            /*Crear subtarea*/
            if($id = $this->TechnicalMasterModel->createSubstakReparation($data)){
                /*Actualizar registro en la tabla roles */
                $msg['msg'] = "Subtarea registrada con éxito.";
                $this->response->sendJSONResponse($msg);
            }else{
                $msg['msg'] = "La subtarea ya se encuentra asignada.";
                $this->response->sendJSONResponse($msg);
                $this->output->set_status_header(405);
            } 	
        }     
        } else {
            redirect('Home/login', 'refresh');
        }
    }     

    public function createSubstakEvaluation()
    {
        if ($this->accesscontrol->checkAuth()['correct']) {
            /* Datos de formulario*/
        $data = $this->input->post('data'); 
        /* Cargar datos para la validación de formulario*/
        $rules = get_rules_substask_create();
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($data);
        $this->form_validation->set_rules($rules);

        /*Validación de formulario
        Si el formulario no es valido*/
        if($this->form_validation->run() == FALSE){
            if(form_error('date_assignment')) $msg['date'] = form_error('date_assignment');
            if(form_error('subtask_id')) $msg['substak'] = form_error('subtask_id');
            if(form_error('user_id')) $msg['ta'] = form_error('user_id');
            $this->response->sendJSONResponse($msg);
            $this->output->set_status_header(400); 
        }else{
        /*Si el formulario es valido*/
            /*Crear subtarea*/
            if($id = $this->TechnicalMasterModel->createSubstakEvaluation($data)){
                /*Actualizar registro en la tabla roles */
                $msg['msg'] = "Subtarea registrada con éxito.";
                $this->response->sendJSONResponse($msg);
            }else{
                $msg['msg'] = "La subtarea ya se encuentra asignada.";
                $this->response->sendJSONResponse($msg);
                $this->output->set_status_header(405);
            } 	
        }     
        } else {
            redirect('Home/login', 'refresh');
        }
    }  

    //Funcion para editar una subtarea de reparación
    public function updateSubstakReparation()
    {
        if ($this->accesscontrol->checkAuth()['correct']) {
            /* Datos de formulario*/
        $data = $this->input->post('data'); 
        /* Cargar datos para la validación de formulario*/
        $rules = get_rules_substask_create();
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($data);
        $this->form_validation->set_rules($rules);
        /*Validación de formulario
        Si el formulario no es valido*/
        if($this->form_validation->run() == FALSE){
            if(form_error('date_assignment')) $msg['date'] = form_error('date_assignment');
            if(form_error('subtask_id')) $msg['substak'] = form_error('subtask_id');
            if(form_error('user_id')) $msg['ta'] = form_error('user_id');
            $this->response->sendJSONResponse($msg);
            $this->output->set_status_header(400); 
        }else{
        /*Si el formulario es valido*/
            /*Crear subtarea*/
            if($id = $this->TechnicalMasterModel->updateSubstakReparation($data)){
                /*Actualizar registro en la tabla roles */
                $msg['msg'] = "Subtarea actualizada con éxito.";
                $this->response->sendJSONResponse($msg);
            }else{
                $msg['msg'] = "La subtarea ya se encuentra asignada.";
                $this->response->sendJSONResponse($msg);
                $this->output->set_status_header(405);
            } 	
        }     
        } else {
            redirect('Home/login', 'refresh');
        }
    }  

    public function updateSubstakEvaluation()
    {
        if ($this->accesscontrol->checkAuth()['correct']) {
            /* Datos de formulario*/
        $data = $this->input->post('data'); 
        /* Cargar datos para la validación de formulario*/
        $rules = get_rules_substask_create();
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($data);
        $this->form_validation->set_rules($rules);
        /*Validación de formulario
        Si el formulario no es valido*/
        if($this->form_validation->run() == FALSE){
            if(form_error('date_assignment')) $msg['date'] = form_error('date_assignment');
            if(form_error('subtask_id')) $msg['substak'] = form_error('subtask_id');
            if(form_error('user_id')) $msg['ta'] = form_error('user_id');
            $this->response->sendJSONResponse($msg);
            $this->output->set_status_header(400); 
        }else{
        /*Si el formulario es valido*/
            /*Crear subtarea*/
            if($id = $this->TechnicalMasterModel->updateSubstakEvaluation($data)){
                /*Actualizar registro en la tabla roles */
                $msg['msg'] = "Subtarea actualizada con éxito.";
                $this->response->sendJSONResponse($msg);
            }else{
                $msg['msg'] = "La subtarea ya se encuentra asignada.";
                $this->response->sendJSONResponse($msg);
                $this->output->set_status_header(405);
            } 	
        }     
        } else {
            redirect('Home/login', 'refresh');
        }
    }  

    public function desHabSubstakReparation(){
        if ($this->accesscontrol->checkAuth()['correct']) {
            /* Datos de formulario*/
            $data = $this->input->post('data');
            $state = $data['state'];
    
            /* Variables a utilizar*/
            $hab_des=""; /*Mensaje dinamico de des/hab*/
            if($state == 0) {$hab_des ="Bloqueada";} else {$hab_des ="Desbloqueada"; } 
    
            /*actualizar state de la empresa*/ 
            if($this->TechnicalMasterModel->desHabSubstakReparation($data)){
                $msg['msg'] = "La subtarea ha sido ".$hab_des." con éxito";
                $this->response->sendJSONResponse($msg);
            }else{
                $msg['msg'] = "No se pudo cargar el recurso.";
                $this->response->sendJSONResponse($msg);
            }
        } else {
            redirect('Home/login', 'refresh');
    
        }   
    }
    
    public function desHabSubstakEvaluation(){
        if ($this->accesscontrol->checkAuth()['correct']) {
            /* Datos de formulario*/
            $data = $this->input->post('data');
            $state = $data['state'];
    
            /* Variables a utilizar*/
            $hab_des=""; /*Mensaje dinamico de des/hab*/
            if($state == 0) {$hab_des ="Bloqueada";} else {$hab_des ="Desbloqueada"; } 
    
            /*actualizar state de la empresa*/ 
            if($this->TechnicalMasterModel->desHabSubstakEvaluation($data)){
                $msg['msg'] = "La subtarea ha sido ".$hab_des." con éxito";
                $this->response->sendJSONResponse($msg);
            }else{
                $msg['msg'] = "No se pudo cargar el recurso.";
                $this->response->sendJSONResponse($msg);
            }
        } else {
            redirect('Home/login', 'refresh');
    
        }   
    }


    public function chronometer(){

        if ($this->accesscontrol->checkAuth()['correct']) {
            $data = $this->input->post('datos');
            $nombre = '';
            if($data['name'] == 'technical_report'){
                $nombre = 'Reporte técnico'; 
            }else if($data['name'] == 'reparation'){
                $nombre = 'Reparación'; 
            }else if($data['name'] == 'subtask_reparation'){
                $nombre = 'Subtarea de reparación';
            }else if($data['name'] == 'subtask_evaluation'){
                $nombre = 'Subtarea de evaluación';
            }

            if($data['msg'] == 'reanudado' || $data['msg'] == 'iniciado'){
                if($this->TechnicalMasterModel->play($data)){
                    $msg['msg'] = $nombre." ".$data['msg']." correctamente";
                    $this->response->sendJSONResponse($msg);
                }else{
                    $msg['msg'] = "No se pudo cargar el recurso.";
                    $this->response->sendJSONResponse($msg);
                }
            }else if($data['msg'] == 'detenido'){
                if($this->TechnicalMasterModel->stop($data)){
                    $msg['msg'] = $nombre." ".$data['msg']." correctamente";
                    $this->response->sendJSONResponse($msg);
                }else{
                    $msg['msg'] = "No se pudo cargar el recurso.";
                    $this->response->sendJSONResponse($msg);
                }
            }
        } else {
            redirect('Home/login', 'refresh');
        }   
    }


    public function chronometerHydraulicTest() {

        if ($this->accesscontrol->checkAuth()['correct']) {
            $data = $this->input->post('datos');

            if($data['msg'] == 'reanudado' || $data['msg'] == 'iniciado'){
                if($this->TechnicalMasterModel->playHydraulicTest($data)){
                    $msg['msg'] = "Reporte técnico ".$data['msg']." correctamente";
                    $this->response->sendJSONResponse($msg);
                }else{
                    $msg['msg'] = "No se pudo cargar el recurso.";
                    $this->response->sendJSONResponse($msg);
                }
            }else if($data['msg'] == 'detenido'){
                if($this->TechnicalMasterModel->stopHydraulicTest($data)){
                    $msg['msg'] = "Reporte técnico ".$data['msg']." correctamente";
                    $this->response->sendJSONResponse($msg);
                }else{
                    $msg['msg'] = "No se pudo cargar el recurso.";
                    $this->response->sendJSONResponse($msg);
                }
            }
        } else {
            redirect('Home/login', 'refresh');
        }   
    }


    public function chronometerEvaluation() {

        if ($this->accesscontrol->checkAuth()['correct']) {
            $data = $this->input->post('datos');

            if($data['msg'] == 'reanudado' || $data['msg'] == 'iniciado'){
                if($this->TechnicalMasterModel->playEvaluation($data)){
                    $msg['msg'] = "Reporte técnico ".$data['msg']." correctamente";
                    $this->response->sendJSONResponse($msg);
                }else{
                    $msg['msg'] = "No se pudo cargar el recurso.";
                    $this->response->sendJSONResponse($msg);
                }
            }else if($data['msg'] == 'detenido'){
                if($this->TechnicalMasterModel->stopEvaluation($data)){
                    $msg['msg'] = "Reporte técnico ".$data['msg']." correctamente";
                    $this->response->sendJSONResponse($msg);
                }else{
                    $msg['msg'] = "No se pudo cargar el recurso.";
                    $this->response->sendJSONResponse($msg);
                }
            }
        } else {
            redirect('Home/login', 'refresh');
        }   
    }









}

