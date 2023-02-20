<?php
defined('BASEPATH') or exit('No direct script access allowed');

class NotificationLate extends CI_Controller
{
    

//evaluaciones atrasadas por tecnico
public function get_orders_late()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $user= $_SESSION["id"];
            $this->load->model('NotificationLateModel');
            $orders = $this->NotificationLateModel->get_orders_late($user);

            $this->response->sendJSONResponse($orders);
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }

}