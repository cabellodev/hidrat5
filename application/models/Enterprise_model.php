<?php

class Enterprise_model extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function get_enterprises(){
        $query=$this->db->get('enterprise')->result();
        if (!$query) {return false;} else{return $query;}  
    }

    public function create($data){
        $this->db->select('*'); $this->db->from('enterprise'); $this->db->where('rut', $data['rut']);
        $this->db->or_where('name', $data['name']);
        $query = $this->db->get();

        if(sizeof($query->result()) != 0){
            return false;
        }else{
            if($this->db->insert('enterprise', $data)){
                return true;
            }else{
                return false;
            }
        }
    }

    public function update($data){

        $query = "SELECT * FROM enterprise WHERE (rut = ? AND rut != ?) OR (name = ? AND name != ?)";
        $result = $this->db->query($query, array($data['rut'], $data['rut_old'], $data['name'], $data['name_old']));

        
        if(sizeof($result->result()) >= 1){
            return false;
        }else{
            $enterprise = array(
                'rut' => $data['rut'],
                'name' => $data['name'],
                'state' => $data['state']
            );
            $this->db->where('rut', $data['rut_old']);
            $this->db->update('enterprise', $enterprise);
            return true;
        }
    }

    public function des_hab($data){
        $this->db->where('rut', $data['rut']);
        $query = $this->db->update('enterprise', $data);
        if($query){
            return true;
        }else{
            return false;
        }
    }
}