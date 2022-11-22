<?php
defined('BASEPATH') or exit('No direct script access allowed');

class NotesModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    public function checkNotes($ot_id){
        $query = "SELECT n.record FROM notes n WHERE n.ot_id = ?";
        $result = $this->db->query($query, array($ot_id));

        if(sizeof($result->result_array()) == 1){
            return true;
        }else{
            return false;
        }
    }

    public function getNotesByOrder($ot_id){
        $query = "SELECT n.record record
        FROM notes n
        WHERE n.ot_id = $ot_id"; 
        return $this->db->query($query)->result_array(); 
    }

    public function createNote($data){
        $user = $_SESSION['full_name'];
        date_default_timezone_set("America/Santiago");
        $date = date("Y-m-d G:i:s");
        $details_record = [];

        if($data['notes'] != 'false'){
            for($i=0; $i<count($data['notes']); $i++){
                $note = array(
                    'id' => $data['notes'][$i]['id'],
                    'date_created' => $data['notes'][$i]['date_created'],
                    'date_modified' => $data['notes'][$i]['date_modified'],
                    'content' => $data['notes'][$i]['content'],
                    'user' => $data['notes'][$i]['user'],
                    'createdByCurrentUser' => $data['notes'][$i]['createdByCurrentUser'],
                );
                array_push($details_record, $note);
            }
        }

        $note = array(
            'id' => $data['id'],
            'date_created' => $date,
            'date_modified' => '',
            'content' => $data['content'],
            'user' => $user,
            'createdByCurrentUser' => $user,
        );
        array_push($details_record, $note);


        $data_notes = array(
            'record' => json_encode($details_record),
        ); 
       
        $this->db->where('ot_id', $data['ot_id']);
        if($this->db->update('notes', $data_notes)) return $note; else return false;
    }

    public function updateNote($data){
            $data_notes = array(
                'record' => json_encode($data['notes']),
            ); 
           
            $this->db->where('ot_id', $data['ot_id']);
            if($this->db->update('notes', $data_notes)) return true; else return false;

    }
}