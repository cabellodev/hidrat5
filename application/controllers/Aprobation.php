<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aprobation extends CI_Controller
{
    public function getAprobationByOrder($id)
    { 
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('AprobationModel');
            if($res=$this->AprobationModel->getAprobationByOrder($id)){
                $this->response->sendJSONResponse($res); 
            }else{
                $this->response->sendJSONResponse(array('msg' => 'Error al traer información'), 400); 
            }
            }else{
                
                $this->response->sendJSONResponse(array('msg' => 'No tiene permisos suficientes.'), 400);
            }
    }

    public function editAprobation($id){

        if($this->accesscontrol->checkAuth()['correct']) {

        $data = $this->input->post('data');
        $date_ap = $data['date_ap'];
        $number_qt = $data['qt_number'];
        $ok=true;
    
        if (is_numeric ($number_qt)) { $ok=true;  }else{
            $ok = false; 
        }

        if($number_qt<0){
            $ok = false; 
        }
       
        if($ok){ 
            $this->load->model('AprobationModel');
            if($this->AprobationModel->editAprobation($id,$data)){
            $this->response->sendJSONResponse( array("msg"=>"Se ha editado con éxito "));
            }else{ 
            $this->response->sendJSONResponse( array("msg" => "No se han podido editar los datos "),400); 
            }
            
        }else { $this->response->sendJSONResponse( array( "msg"=>"Numero de cotización no válido." ),400); } 

        }else {
            $this->response->sendJSONResponse( array("msg" => "No tiene los permisos suficientes "),400);
        }
    }


    public function editOC($id)
    {   
        
        $config['upload_path'] = "./assets/upload/purshaseOrder/";
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
            $this->load->model('AprobationModel');
                 if ( $res = $this->AprobationModel->uploadOC($id, $pdf)) {
                     $this->response->sendJSONResponse(array('msg' => "Archivo subido con éxito."));
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


    public function getOC($id)
    { 

        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('AprobationModel');
            if($res=$this->AprobationModel->getOC($id)){
                $this->response->sendJSONResponse($res); 
            }else{
                $this->response->sendJSONResponse(array('msg' => 'No se han podido traer los datos del archivo'), 400); 
            }
            }else{
                
                $this->response->sendJSONResponse(array('msg' => 'No tiene permisos suficientes.'), 400);
            }
    }




    public function deleteOC($id)
    {
        if ($this->accesscontrol->checkAuth()['correct']) {
            
            $data = $this->input->post('data');
            $name = $data['pdf'];
            $this->load->model('AprobationModel');
            if ($response = $this->AprobationModel->deleteOC($id)) {
                unlink('./assets/upload/purshaseOrder/' . $name);
                $this->response->sendJSONResponse(array("msg" => "El archivo fue eliminado con éxito"));
            } else {
                $this->response->sendJSONResponse(array('status' => "error"), 500);
            }
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }
}




    

