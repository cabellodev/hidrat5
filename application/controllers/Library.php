<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Library extends CI_Controller

{
    public function adminLibrary()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->view('shared/headerSuperAdmin');
            $this->load->view('admin/adminLibrary');
            $this->load->view('shared/footer');
        } else {
            redirect('Home/login', 'refresh');
        }
    }


    public function view_document()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $url = parse_url($_SERVER['REQUEST_URI']);
            parse_str($url['query'], $params);
            $name = $params['ot'];
            $data['name']=$name;
            $this->load->view('admin/viewDocument',$data);
        } else {
            redirect('Home/login', 'refresh');
        }
    }


    public function create_document(){
       
        if ($this->accesscontrol->checkAuth()['correct']) {
            $data = $this->input->post('data');
            $ok = true;
            if($data['name']==""){$ok= false; }
            

            if($ok){

            $this->load->model('LibraryModel');
            if($id=$this->LibraryModel->create_document($data)) { 
                $this->response->sendJSONResponse(array("id"=>$id));
            } else { 
                $this->response->sendJSONResponse(array('msg' => "error"), 400);
            }
        }else{
            $this->response->sendJSONResponse(array('msg' => "Complete todos los campos del formulario.( nombre y correlativo)"),400);
        }
        } else {
            redirect('Home/login', 'refresh');
        }
    }


    public function edit_documents(){
        if ($this->accesscontrol->checkAuth()['correct']) {
            $data = $this->input->post('data');
            $ok = true;
            if($data['name']==""){$ok= false; }

            if($ok){

            $this->load->model('LibraryModel');
            if($this->LibraryModel->edit_document($data)) { 

                $this->response->sendJSONResponse(array("id"=>$data['id']));
            } else { 
                $this->response->sendJSONResponse(array('msg' => "error"), 400);
            }
        }else{
            $this->response->sendJSONResponse(array('msg' => "Ingrese el campo de nombre porfavor."),400);
        }
        } else {
            redirect('Home/login', 'refresh');
        }
    }


    public function documentUpload($id){

     
        $config['upload_path'] = "./assets/upload/";
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
            $this->load->model('LibraryModel');
                 if ( $this->LibraryModel->update_document($pdf,$id)) {
                     $this->response->sendJSONResponse(array('msg' => "EXITO"));
                     } else {
                       $this->response->sendJSONResponse(array('msg' => "error"), 500);
                      }
            }else { $this->response->sendJSONResponse(array('msg' => "Cargue un formato correcto por favor"), 500); } 
        } else {
            $this->response->sendJSONResponse(array(
                "msg" => "error",
                "id" => $id, "i" => $this->upload->display_errors(),
                "c" => $config['upload_path']
            ));
        }
    }

    public function documentUpload2($id){

     
        $config['upload_path'] = "./assets/upload/";
        $config['allowed_types'] = '*';
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
       
        if ($this->upload->do_upload("oce")) {
            $data = array('upload_data' => $this->upload->data());
            $pdf = $data['upload_data']['file_name'];
            $array = explode(".", $pdf); //divide string y convierte en array 
           
            $formato =  $array[1];// selecciona el indice 1 igual a pdf 
        
            if($formato == "pdf") {
            $this->load->model('LibraryModel');
                 if ( $this->LibraryModel->update_document($pdf,$id)) {
                     $this->response->sendJSONResponse(array('msg' => "EXITO"));
                     } else {
                       $this->response->sendJSONResponse(array('msg' => "error"), 500);
                      }
            }else { $this->response->sendJSONResponse(array('msg' => "Cargue un formato correcto por favor"), 500); } 
        } else {
            $this->response->sendJSONResponse(array(
                "msg" => "error",
                "id" => $id, "i" => $this->upload->display_errors(),
                "c" => $config['upload_path']
            ));
        }
    }


    public function get_document(){
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('LibraryModel');
            if($res=$this->LibraryModel->get_document()) { 
                $this->response->sendJSONResponse($res);
            } else { 
                $this->response->sendJSONResponse(array('msg' => "error"), 400);
            }
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    public function get_tags(){
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('LibraryModel');
            if($res=$this->LibraryModel->get_tags()) { 
                $this->response->sendJSONResponse($res);
            } else { 
                $this->response->sendJSONResponse(array('msg' => "error"), 400);
            }
        } else {
            redirect('Home/login', 'refresh');
        }
    }


    public function create_tag(){
        if ($this->accesscontrol->checkAuth()['correct']) {
            $data = $this->input->post('data');

            $this->load->model('LibraryModel');
            if($this->LibraryModel->create_tag($data)) { 
                $this->response->sendJSONResponse(array('msg' => "Archivo subido con éxito."));
            } else { 
                $this->response->sendJSONResponse(array('msg' => "El tag ingresado ya existe. Reintente con otro nombre."), 400);
            }
        } else {
            redirect('Home/login', 'refresh');
        }

    }


    public function edit_tag(){
       
        if ($this->accesscontrol->checkAuth()['correct']) {
            $data = $this->input->post('data');
         
            $this->load->model('LibraryModel');
            if($this->LibraryModel->edit_tag($data)) { 
                $this->response->sendJSONResponse(array('msg' => "Actualizado con exito."),200);
            } else { 
                $this->response->sendJSONResponse(array('msg' => "Esta ingresando el mismo tag u otro que ya existe. Pruebe con otro nombre."), 400);
            }
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    public function update_tags(){
       
        if ($this->accesscontrol->checkAuth()['correct']) {
            $data = $this->input->post('data');
            $this->load->model('LibraryModel');
            if($this->LibraryModel->update_tags($data)) { 
                $this->response->sendJSONResponse(array('msg' => "Actualizado con exito."),200);
            } else { 
                $this->response->sendJSONResponse(array('msg' => "Esta ingresando el mismo tag. Edite con un nombre nuevo."), 400);
            }
        } else {
            redirect('Home/login', 'refresh');
        }
    }


    public function delete_tags(){

        if ($this->accesscontrol->checkAuth()['correct']) {

            $data = $this->input->post('data');
            $this->load->model('LibraryModel');

            if($this->LibraryModel->delete_tags($data)) { 
                $this->response->sendJSONResponse(array('msg' => "Eliminado con exito."));
            } else { 
                $this->response->sendJSONResponse(array('msg' => "error"), 400);
            }
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    public function change_state_documents(){

        if ($this->accesscontrol->checkAuth()['correct']) {

            $data = $this->input->post('data');
            $this->load->model('LibraryModel');
            
            if($this->LibraryModel->change_state_documents($data)) { 
                $this->response->sendJSONResponse(array('msg' => "Estado cambiado con éxito."));
            } else { 
                $this->response->sendJSONResponse(array('msg' => "error"), 400);
            }
        } else {
            redirect('Home/login', 'refresh');
        }
    }



   

// function for technical master

public function access_user(){

  
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('LibraryModel');
            if($res=$this->LibraryModel->access_user()) { 
                $this->response->sendJSONResponse($res);
            } 
        } else {
            redirect('Home/login', 'refresh');
        }
}






public function searchDocumentation()
{ 
    
    if ($this->accesscontrol->checkAuth()['correct']) {
        $this->load->view('shared/headerTechnicalMaster');
        $this->load->view('TechnicalMaster/searchLibrary');
        $this->load->view('shared/footer');
    } else {
        redirect('Home/login', 'refresh');
    }
}



public function get_document_active(){
     if ($this->accesscontrol->checkAuth()['correct']) {
         $this->load->model('LibraryModel');
          if($res=$this->LibraryModel->get_document_active()) { 
            $this->response->sendJSONResponse($res);
      } else { 
                $this->response->sendJSONResponse(array('msg' => "error"), 400);
     }
      } else {
            redirect('Home/login', 'refresh');
      }
    }

}


