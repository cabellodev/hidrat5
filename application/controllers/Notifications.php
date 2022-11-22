<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notifications extends CI_Controller
{
    public function get_notifications()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('NotificationsModel');
            $datos = $this->NotificationsModel->get_notifications();
            $this->response->sendJSONResponse($datos);
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }


    public function get_user_notifications()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('NotificationsModel');
            $datos = $this->NotificationsModel->get_user_notifications();
            $this->response->sendJSONResponse($datos);
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }

    public function get_id_user()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('NotificationsModel');
            $user= $_SESSION["id"];
            $datos = $this->NotificationsModel->get_user_notifications();
            $this->response->sendJSONResponse(array("id_user"=>$user));
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }

    public function change_notification($id){
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('NotificationsModel');
            $data = $this->input->post('data');
		
			if ($this->NotificationsModel->change_notification($id,$data)) {
				$this->response->sendJSONResponse(array('msg' => "Estado cambiado exitosamente."));
			} else {
				$this->response->sendJSONResponse(array('msg' => "No se pudo cambiar el estado."), 400);
			}
		} else {
			$this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
		}

    }


  


    
}