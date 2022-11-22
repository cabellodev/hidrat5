<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Subtask extends CI_Controller
{
    public function adminSubtask()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $rango = $_SESSION['rango'];
            if($rango == 1){
            $this->load->view('shared/headerSuperAdmin');
            $this->load->view('admin/adminSubtask');
            $this->load->view('shared/footer');
            }else if($rango == 2){
                $this->load->view('shared/headerAdmin');
                $this->load->view('admin/adminSubtask');
                $this->load->view('shared/footer');

            }
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    
    public function getSubtask()
    {
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('SubtaskModel');
            $datos = $this->SubtaskModel->getSubtask();
            $this->response->sendJSONResponse($datos);
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }
    
    public function createSubtask()
    {
        if ($this->accesscontrol->checkAuth()['correct']) {
            $data = $this->input->post('data');
            $name = $data['name'];
           

            $ok = true;
            $err = array();

            if ($name == "") {
                $ok = false;
                $err['name']  = "Ingrese un nombre.";
            }
            
           
            if ($ok) {
              
                $this->load->model('SubtaskModel');
                $res=$this->SubtaskModel->insertSubtask($name);
                if($res){ 
                    $this->response->sendJSONResponse(array('msg' => "Subtarea creada."));
                }else{
	                $this->response->sendJSONResponse(array('msg' => "El nombre ya existe. Reintente con otro." ,'err'=>"Ingrese un nombre"), 400);
                }
               
            } else {
                $this->response->sendJSONResponse(array('msg' => "Ingrese un nombre por favor." ,'err'=>'Ingrese un nombre'), 400);
            }
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }




    public function editSubtask()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			$data = $this->input->post('data');
			$name = $data['name'];
			$id= $data['id'];
	
			$ok = true;
			$err = array();

			if ($name == "") {
				$ok = false;
				$err['name']  = "Ingrese un nombre .";
			}
		
			if ($ok) {
				$this->load->model('SubtaskModel');
				$res = $this->SubtaskModel->updateSubtask($name,$id);
				if ($res) {
					$this->response->sendJSONResponse(array('msg' => "Subtarea modificada."));
				} else {
                    $this->response->sendJSONResponse(array('msg' => "El nombre ya existe. Reintente con otro." ,'err'=>"Ingrese un nombre"), 400);
				}
			} else {
				$this->response->sendJSONResponse(array('msg' => "Ingrese un nombre por favor" ,'err'=>'Ingrese un nombre'), 400);
			}
		} else {
			$this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
		}
    }


    public function changeState()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			$this->load->model('SubtaskModel');
			$data = $this->input->post('data');
			$state = $data['state'];
			$id = $data['id'];
			$res = $this->SubtaskModel->changeState($id, $state);
			if ($res) {
				$this->response->sendJSONResponse(array('msg' => "Estado cambiado exitosamente."));
			} else {
				$this->response->sendJSONResponse(array('msg' => "No se pudo cambiar el estado."), 400);
			}
		} else {
			$this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
		}
	}






}
