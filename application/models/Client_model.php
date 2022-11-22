<?php

class Client_model extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function get_clients(){
        $this->db->select('c.email email, c.state state, c.full_name name, r.description role, e.name enterprise, u.full_name seller' );
        $this->db->from('client c');    
        $this->db->join('client_role cr', 'cr.client_id = c.id','left');
        $this->db->join('roleClient r', 'r.id = cr.roleClient_id','left');
        $this->db->join('enterprise e', 'e.id = c.enterprise_id','left');
        $this->db->join('user u', 'u.id = c.seller_assignment','left');
        return $query = $this->db->get()->result();
    }

    public function get_roles(){
        return $query=$this->db->get('roleClient')->result();
    }

    public function get_enterprises(){

        return $query=$this->db->get('enterprise')->result();
    }

    public function get_sellers(){
        $this->db->select('u.id, u.full_name' );
        $this->db->from('user u');
        $this->db->join('user_role ur', 'ur.user_id = u.id','left');
        $this->db->where('ur.role_id', '5');
        return $query = $this->db->get()->result();
    }

    public function create($data){
        $this->db->select('*'); $this->db->from('client'); $this->db->where('email', $data['email']);
        $query = $this->db->get();

        if(sizeof($query->result()) != 0){
            return false;
        }else{
            $hash = password_hash($data['passwd'], PASSWORD_DEFAULT, ['cost' => 13]);
            $datos_client = array(
                'password' => $hash,
                'full_name' => $data['full_name'],
                'email' => $data['email'],
                'seller_assignment' => $data['seller'],
                'state' => 1,
                'enterprise_id' => $data['enterprise'],
                'seller_assignment' => 51,
            );

            if($this->db->insert('client', $datos_client)){
                $this->db->select('id'); 
                $this->db->from('client'); 
                $this->db->where('email', $data['email']);
                $query = $this->db->get();
                return $query->row_array();
            }else{
                return false;
            }
        }
    }

    public function create_rol($data, $data_user){
        $datos_role = array(
            'client_id' => $data_user['id'],
            'roleClient_id' => $data['range'],
        );

        if($this->db->insert('client_role', $datos_role)){
            return true;
        }else{
            return false;
        }
    }

    public function update($data){
        $query = "SELECT * FROM client WHERE (email = ? AND email != ?)";
        $result = $this->db->query($query, array($data['email'], $data['email_old']));

        if(sizeof($result->result()) >= 1){
            return false;
        }else{
            $datos_client = array(
                'full_name' => $data['full_name'],
                'email' => $data['email'],
                'state' => 1,
                'seller_assignment' => $data['seller'],
                'enterprise_id' => $data['enterprise'],
            );
            $this->db->where('email', $data['email_old']);
            
            if($this->db->update('client', $datos_client)){
                $email="";
                if($data['email'] === $data['email_old']){
                    $email = $data['email_old'];
                }else{
                    $email = $data['email'];
                }
                $this->db->select('id'); 
                $this->db->from('client'); 
                $this->db->where('email', $email);
                return $this->db->get()->row_array();;
            }else{
                return false;
            }
            return true;
        }
    }

    public function update_rol($data, $id){
         $datos_role = array(
            'client_id' => $id['id'],
            'roleClient_id' => $data['range'],
        );
        $this->db->where('client_id', $id['id']);
        if($this->db->update('client_role', $datos_role)) {return true;} else{return false;} 
    }

    public function des_hab($data){
        $this->db->where('rut', $data['rut']);
        $query = $this->db->update('client', $data);
        if($query){
            return true;
        }else{
            return false;
        }
    }
}