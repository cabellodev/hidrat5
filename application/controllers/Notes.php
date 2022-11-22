<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notes extends CI_Controller
{
    public function __construct(){
		parent:: __construct(); 
		$this->load->model('NotesModel');
	}

    public function getNotesByOrder($id)
    {
        if ($this->accesscontrol->checkAuth()['correct']) {
            if($this->NotesModel->checkNotes($id)){
                if($notes= $this->NotesModel->getNotesByOrder($id)){
                    $user = $_SESSION['full_name'];
                    $this->response->sendJSONResponse(array($notes, $user)); 
                }else{
                    $msg['msg'] = "Error al obtener las notas asociadas a la órden de trabajo";
                    $this->response->sendJSONResponse($msg);
                    $this->output->set_status_header(405);
                } 
            }else{
                $msg['msg'] = "No hay notas asociadas a esta OT";
                $this->response->sendJSONResponse($msg);
                $this->output->set_status_header(400);
            }
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    public function createNote()
    {
        if ($this->accesscontrol->checkAuth()['correct']) {
            $data = $this->input->post('data');
            if($note = $this->NotesModel->createNote($data)){
                $this->response->sendJSONResponse($note); 
            }else{
                $msg['msg'] = "Error al crear una nueva nota";
                $this->response->sendJSONResponse($msg);
                $this->output->set_status_header(405);
            } 
        } else {
            redirect('Home/login', 'refresh');
        }
    }
 
    public function updateNote()
    {
        if ($this->accesscontrol->checkAuth()['correct']) {
            $data = $this->input->post('data');
            if($this->NotesModel->updateNote($data)){
                $msg['msg'] = "Nota actualizada con éxito.";
                $this->response->sendJSONResponse($msg); 
            }else{
                $msg['msg'] = "Error al editar la nota";
                $this->response->sendJSONResponse($msg);
                $this->output->set_status_header(405);
            } 
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    public function deleteNote()
    {
        if ($this->accesscontrol->checkAuth()['correct']) {
            $data = $this->input->post('data');
            if($this->NotesModel->updateNote($data)){
                $msg['msg'] = "Nota eliminada con éxito.";
                $this->response->sendJSONResponse($msg); 
            }else{
                $msg['msg'] = "Error al eliminar la nota";
                $this->response->sendJSONResponse($msg);
                $this->output->set_status_header(405);
            } 
        } else {
            redirect('Home/login', 'refresh');
        }
    }
}
