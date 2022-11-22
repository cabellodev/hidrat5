<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Brand extends CI_Controller
{
    public function adminBrand()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $rango = $_SESSION['rango'];
            if($rango == 1){
            $this->load->view('shared/headerSuperAdmin');
            $this->load->view('admin/adminBrand');
            $this->load->view('shared/footer');
            }else if($rango == 2){
            $this->load->view('shared/headerAdmin');
            $this->load->view('admin/adminBrand');
            $this->load->view('shared/footer');
            }
        } else {
            redirect('Home/login', 'refresh');
        }
    }
    public function getBrand()
    {
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('BrandModel');
            $datos = $this->BrandModel->getBrand();
            $this->response->sendJSONResponse($datos);
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }

    public function createBrand()
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
                $this->load->model('BrandModel');
                $res=$this->BrandModel->insertBrand($name);
                if($res){ 
                    $this->response->sendJSONResponse(array('msg' => "Marca creada.")); 
                }else{ 
                    $this->response->sendJSONResponse(array('msg' => "El nombre ya existe. Reintente con otro." ,'err'=>"Ingrese un nombre"), 400);
                }
            } else {
                $this->response->sendJSONResponse(array('msg' => "Ingrese un nombre" ,'err'=>'Ingrese un nombre'), 400);
            }
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }
  

    
    public function editBrand(){
		if ($this->accesscontrol->checkAuth()['correct']) {
			$data = $this->input->post('data');
			$name = $data['name'];
			$id= $data['id'];
			$ok = true;
			$err = array();

			if ($name == "") {
				$ok = false;
				$err['name']  = "Ingrese un nombre de marca.";
			}
		
		
			if ($ok) {
				$this->load->model('BrandModel');
				$res = $this->BrandModel->updateBrand($name,$id);
				if ($res) {
					$this->response->sendJSONResponse(array('msg' => "Marca modificada."));
				} else {
                    $this->response->sendJSONResponse(array('msg' => "El nombre ya existe. Reintente con otro." ,'err'=>"Ingrese un nombre"), 400);
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
			$this->load->model('BrandModel');
			$data = $this->input->post('data');
			$state = $data['state'];
			$id = $data['id'];
			$res = $this->BrandModel->changeState($id, $state);
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
