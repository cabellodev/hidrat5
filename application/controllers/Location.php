<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Location extends CI_Controller
{
    public function adminLocation()
    {

        if ($this->accesscontrol->checkAuth()['correct']) {
            $rango = $_SESSION['rango'];
            if($rango == 1){
            $this->load->view('shared/headerSuperAdmin');
            $this->load->view('admin/adminLocation');
            $this->load->view('shared/footer');

            }else if($rango == 2){

            $this->load->view('shared/headerAdmin');
            $this->load->view('admin/adminLocation');
            $this->load->view('shared/footer');
            }

        } else {
            redirect('Home/login', 'refresh');
        }
    }


    public function getLocation()
    {
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('LocationModel');
            $datos = $this->LocationModel->getLocation();
            $this->response->sendJSONResponse($datos);
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }

    public function createLocation()
    {
        if ($this->accesscontrol->checkAuth()['correct']) {
            $data = $this->input->post('data');
			$name = $data['name'];
			$id= $data['id'];
	
			$ok = true;
			$err = array();
            if ($name == "") {
                $ok = false;
                $err['name']  = "Ingrese un nombre.";
            }
            
            if ($ok) {
              
                $this->load->model('LocationModel');
                $res=$this->LocationModel->insertLocation($name);
                if($res){ 
                    $this->response->sendJSONResponse(array('msg' => "Ubicación creada."));
                }else{
                    $this->response->sendJSONResponse(array('msg' => "Nombre repetido. Reintente",'err'=>"Ingrese un nombre"), 400);
                }
               
            } else {
              
                $this->response->sendJSONResponse(array('msg' => "Ingrese un nombre" ,'err'=>'Ingrese un nombre'), 400);
                //$this->response->sendJSONResponse(array('msg' => "Corrija los errores del formulario", 'err' => $err), 400);
            }
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }

    
    public function editLocation()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			$data = $this->input->post('data');
			$name = $data['name'];
			$id= $data['id'];
	
			$ok = true;
			$err = array();
            if ($name == "") {
                $ok = false;
                $err['name']  = "Ingrese un nombre.";
            }
            
			if ($ok) {
				$this->load->model('LocationModel');
				$res = $this->LocationModel->updateLocation($name,$id);
                
				if ($res) {
					$this->response->sendJSONResponse(array('msg' => "Ubicación modificada."));
				} else {
					$this->response->sendJSONResponse(array('msg' => "Nombre repetido.Reintente" ,'err'=>"Ingrese un nombre"), 400);
				}
			} else {
				$this->response->sendJSONResponse(array('msg' => "Ingrese un nombre" ,'err'=>'Ingrese un nombre'), 400);
			}
		} else {
			$this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
		}
    }


    public function changeState()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			$this->load->model('LocationModel');
			$data = $this->input->post('data');
			$state = $data['state'];
			$id = $data['id'];
			$res = $this->LocationModel->changeState($id, $state);
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
