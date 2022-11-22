<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LoginModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getUser($email, $table)
    {
        $query = $this->db->get_where($table, array('email' => $email), 1)->row();
        if (!$query) {return false;} else{return $query;}  
    }

    public function checkUser($email)
    {
        $query_user = "SELECT * FROM user WHERE email = ?";
        $user = $this->db->query($query_user, array($email));

        if(sizeof($user->result()) >= 1){
            return 1;
        }else{
            $query_client = "SELECT * FROM client WHERE email = ?";
            $client = $this->db->query($query_client, array($email));

            if(sizeof($client->result()) >= 1){
                return 2;
            }else{
                return 3;
            }
        }
    }


    public function checkRole($user_id, $table, $id)
    {
        $id = $id.'_id';
        $query = $this->db->get_where($table, array($id => $user_id), 1)->row();
        if (!$query) {return false;} else{return $query;}  
    }

    public function get_user($email)
    {
        $query = $this->db->get_where('user', array('email' => $email), 1)->row();
        if (!$query) {return false;} else{return $query;}  
    }

    public function get_user_with_code($code){
        $query = $this->db->get_where('user', array('code_recovery' => $code), 1)->row();
        if (!$query) {return false;} else{return $query;} 
    }

    public function recovery_password($id, $code, $date)
    {
        $datos_user = array(
            'id' => $id,
            'code_recovery' => $code,
            'date_recovery' => $date,
        );
        $this->db->where('id', $id);
        if($this->db->update('user', $datos_user)){return true;}else{return false;};
    }

    public function new_password($email, $passwd)
    {
        $hash = password_hash($passwd, PASSWORD_DEFAULT, ['cost' => 13]);
        $datos_user = array(
            'password' => $hash,
        );
        $this->db->where('email', $email);
        if($this->db->update('user', $datos_user)){return true;}else{return false;};
    }
    
}
