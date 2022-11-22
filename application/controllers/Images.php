
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Images extends CI_Controller
{   

    public function adminImages()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $url = parse_url($_SERVER['REQUEST_URI']);
            parse_str($url['query'], $params);
            $id = $params['ot'];
			$user =$_SESSION['rango'] ;
			if($user== 3){
				$this->load->view('shared/headerTechnicalMaster');
				$this->load->view('TechnicalMaster/adminImages', array ('id'=> $id));
				$this->load->view('shared/footer');
			}else if($user==1){
            $this->load->view('shared/headerSuperAdmin');
            $this->load->view('admin/adminImages', array ('id'=> $id));
            $this->load->view('shared/footer');
		    }else if($user==2){
			$this->load->view('shared/headerAdmin');
            $this->load->view('admin/adminImages', array ('id'=> $id));
            $this->load->view('shared/footer');
			} 
        } else {
			redirect('Home/login', 'refresh');
        }
    }

    public function getImagesByOrder($id)
    {
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('ImageModel');
            $datos = $this->ImageModel->getImagesByOT($id);
            $this->response->sendJSONResponse($datos);
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }

    public function addImage()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			$imagen = $this->input->post("data");
			$this->load->model('ImageModel');
			$err = "";
			$err_image="";
			$valid = true;
			$image=0;
			$name=0;
			
			if (empty($imagen['name'])) {
				$err = "Ingrese un nombre";
				$valid = false;
				
			}
			
			if ($imagen['file'] == 0) {
				$err_image= "Debe seleccionar una foto";
				$valid = false;
			
			}
			
			
			if (!$valid) {
				$this->response->sendJSONResponse(array('status' => "fail", "err" => $err ,"err_i"=>$err_image), 500);
			} else {
				$s = $this->ImageModel->insertImage($imagen);
				if ($s['status'] == "success") {
					$this->response->sendJSONResponse(array('status' => $s['status'], "id" => $s['id']));
				} else {
					$this->response->sendJSONResponse(array('status' => $s['status']), 500);
				}
			}
		} else {
			$this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
		}
	}



	public function editImage($id)
	{
		
		if ($this->accesscontrol->checkAuth()['correct']) {
			$imagen = $this->input->post("data");
			$this->load->model('ImageModel');
		
			$valid_image = true;
			$valid_name= true;
			
			if (empty($imagen['name'])) {
				$err = "Ingrese un nombre";
				$valid_image = false;
			}
			
			if ($imagen['file'] == 0) {
				$err_image= "Debe seleccionar una foto";
				$valid_name = false;
			}
			
			if (!$valid_image && !$valid_name) {
				$this->response->sendJSONResponse(array('status' => "fail", "err" => "Edite nombre o archivo"), 500);

			} else {
				$s = $this->ImageModel->editImagen($imagen,$id);
				if ($s['status'] == "success") {
					$this->response->sendJSONResponse(array('status' => $s['status'],"id" => $s['id']));
				} else {
					$this->response->sendJSONResponse(array('status' => $s['status'], "err" => $err), 500);
				}
			}
		} else {
			$this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
		}
	}



    public function upImage($id)
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			$config['upload_path'] = "./assets/upload/";
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['max_size'] = '10000000';

			$config['encrypt_name'] = TRUE;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ($this->upload->do_upload("file")) {
				$data = array('upload_data' => $this->upload->data());
				$image = $data['upload_data']['file_name'];
				$this->load->model('ImageModel');
				$s = $this->ImageModel->imageUpload($id, $image);
            
				if ($s == "success") {
					$this->response->sendJSONResponse(array("id" => $id, "i" => $image));
				} else {
					$this->response->sendJSONResponse(array('status' => "error"), 500);
				}
			} else {
				$this->response->sendJSONResponse(array(
					"id" => $id, "i" => $this->upload->display_errors(),
					"c" => $config['upload_path']
				));
			}
		} else {
			$this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
		}
	}




	public function upMultiplesImage($id)
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			
			$config['upload_path'] = "./assets/upload/";
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['max_size'] = '10000000';
			
			$config['encrypt_name'] = TRUE;

            $files= count($_FILES['file']['name'] );
            $aux = $_FILES;
			$msg="";
			$validate = 0;
			for($i=0;$i < $files ;$i++){

				$_FILES['file']['name'] = $aux['file']['name'][$i];
				$_FILES['file']['type']=  $aux['file']['type'][$i];
				$_FILES['file']['tmp_name']=$aux['file']['tmp_name'][$i];
				$_FILES['file']['error']=$aux['file']['error'][$i];
				$_FILES['file']['size']=$aux['file']['size'][$i];

				

	
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($this->upload->do_upload("file")) {
					$data = array('upload_data' => $this->upload->data());
					$image = $data['upload_data']['file_name'];
					$this->load->model('ImageModel');
					$s = $this->ImageModel->insert_Image($id, $image);
					if ($s == "success") {
						 $this->load->library('image_lib');
                         $type = array('image/png'=>'png','image/jpg'=>'jpg','image/jpeg'=>'jpg');
                         //$config['image_library'] = 'gd2';
                         $config['source_image'] = './assets/upload/'.$image;//.'.'.$type[$_FILES['file']['type']];
						
						 $config['create_thumb'] = FALSE;
						 $config['width'] = 400;
						 $config['height']= 350;
						// $config['quality'] = '20';
						 $config['new_image'] = './assets/upload/'.$image;//';
					
                         $this->image_lib->initialize($config);
                         if($this->image_lib->resize()){
							 $this->image_lib->display_errors();
						 }

					    $msg="Imagenes registradas con exito";
					} else {
					    $validate += 1 ;
					}
				} else {
					$validate++;
					$this->response->sendJSONResponse(array(
						"id" => $id, "i" => $this->upload->display_errors(),
						"c" => $config['upload_path']
					));
				}
			}//fin for
			
			    if($validate >0){
                    $this->response->sendJSONResponse(array("msg" => "Uno de los archivos tiene formato no compatible."),400);
				}else{ 
					$this->response->sendJSONResponse(array("msg" => $msg));
				}

		} else {
			$this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
		}
	}



	public function deleteImage($id)
	{
		
	   if ($this->accesscontrol->checkAuth()['correct']) {
              $this->load->model('ImageModel');
                 if( $res = $this->ImageModel->deleteImage($id)){
			         $this->response->sendJSONResponse(array('msg'=> 'La imagen se ha eliminado correctamente.'));
		        }else{
			         $this->response->sendJSONResponse(array('msg'=> 'Error al eliminar la imagen.'),400);
		         }		
	    } else {
		    $this->response->sendJSONResponse(array('status' => 'Faltan permisos de usuario.'),400);
	      }
			
	}








}





