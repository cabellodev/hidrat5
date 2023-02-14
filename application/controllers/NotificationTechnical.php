<?php
defined('BASEPATH') or exit('No direct script access allowed');

class NotificationTechnical extends CI_Controller
{
    


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

    public function createNotification(){
       
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('NotificationsTechnicalModel');
            $data = $this->input->post('data');
            if($this->NotificationsTechnicalModel->createNotification($data)){
                $this->response->sendJSONResponse(array('msg' => 'exito'), 200);
            }else{
                $this->response->sendJSONResponse(array('msg' => 'Error en guardado'), 400);
            }
        } else {
            redirect('Home/login', 'refresh');
        }
    }


    public function  getUserAdmin(){
       
        if ($this->accesscontrol->checkAuth()['correct']) {
                  $user=$_SESSION['full_name'];
                  $this->response->sendJSONResponse(array('msg' => $user), 200);
        } else {
            redirect('Home/login', 'refresh');
        }
    }







    public function  getNotifications()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('NotificationsTechnicalModel');
            $datos = $this->NotificationsTechnicalModel->getNotifications();
            $this->response->sendJSONResponse($datos);
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }


    public function  getNotificationByTechnical(){

  
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('NotificationsTechnicalModel');
            $datos = $this->NotificationsTechnicalModel->getNotificationsByTechnical();
            $this->response->sendJSONResponse($datos);
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }

    }


    public function  changeState(){

        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('NotificationsTechnicalModel');
            $data = $this->input->post('data');
            $datos = $this->NotificationsTechnicalModel->changeState($data);
            $this->response->sendJSONResponse($datos);
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }

    }



   


  


    
}