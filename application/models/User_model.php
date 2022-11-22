<?php

class User_model extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function get_users(){
        $this->db->select('u.*, r.description');
        $this->db->from('user u');
        $this->db->join('user_role ur', 'ur.user_id = u.id','left');
        $this->db->join('role r', 'r.id = ur.role_id','left');
        return $query = $this->db->get()->result();
    }

    public function get_roles(){
        return $query=$this->db->get('role')->result();
    }

    public function create($data){
        $this->db->select('*'); $this->db->from('user'); $this->db->where('rut', $data['rut']);
        $this->db->or_where('email', $data['email']);
        $query = $this->db->get();

        if(sizeof($query->result()) != 0){
            return false;
        }else{
            $hash = password_hash($data['passwd'], PASSWORD_DEFAULT, ['cost' => 13]);
            $datos_user = array(
                'rut' => $data['rut'],
                'password' => $hash,
                'full_name' => $data['full_name'],
                'email' => $data['email'],
                'state' => 1,
            );
            if($this->db->insert('user', $datos_user)){
                $this->db->select('id'); 
                $this->db->from('user'); 
                $this->db->where('rut', $data['rut']);
                $query = $this->db->get();
                return $query->row_array();
            }else{
                return false;
            }
        }
    }

    public function create_rol($data_rol, $data_user){
        
        $datos_role = array(
            'user_id' => $data_user['id'],
            'role_id' => $data_rol['range'],
        );
        if($this->db->insert('user_role', $datos_role)){
            return true;
        }else{
            return false;
        }
    }

    public function update($data){
        $query = "SELECT * FROM user WHERE (rut = ? AND rut != ?) OR (email = ? AND email != ?)";
        $result = $this->db->query($query, array($data['rut'], $data['rut_old'], $data['email'], $data['email_old']));

        if(sizeof($result->result()) >= 1){
            return false;
        }else{
            $datos_user = array(
                'rut' => $data['rut'],
                'full_name' => $data['full_name'],
                'email' => $data['email'],
                'state' => 1,
            );
            $this->db->where('rut', $data['rut_old']);
            if($this->db->update('user', $datos_user)){
                $rut="";
                if($data['rut'] === $data['rut_old']){
                    $rut = $data['rut_old'];
                }else{
                    $rut = $data['rut'];
                }
                $this->db->select('id'); 
                $this->db->from('user'); 
                $this->db->where('rut', $rut);
                return $this->db->get()->row_array();;
            }else{
                return false;
            }
        }
    }

    public function update_rol($data, $id){
        $datos_role = array(
            'user_id' => $id['id'],
            'role_id' => $data['range'],
        );
        $this->db->where('user_id',  $id['id']);
        if($this->db->update('user_role', $datos_role)) {return true;} else{return false;}
    }

    public function des_hab($data){
        $this->db->where('rut', $data['rut']);
        $query = $this->db->update('user', $data);
        if($query){
            return true;
        }else{
            return false;
        }
    }
}