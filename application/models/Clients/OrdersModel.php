<?php
defined('BASEPATH') or exit('No direct script access allowed');

class OrdersModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getOrders()
    {        
        $id = $_SESSION['id'];
        $sql="SELECT  c.enterprise_id 
        FROM client c 
        WHERE c.id = $id";
        $q = $this->db->query($sql)->row_array();
        $id_enterprise = $q['enterprise_id'];

        $query = "SELECT ot.id id, ot.date_admission date, ot.type_service service, c.name component, s.name state
                  FROM ot
                  JOIN enterprise e ON ot.enterprise_id = e.id
                  JOIN component c ON ot.component_id = c.id
                  JOIN ot_state os ON ot.id = os.ot_id
                  JOIN state s ON os.state_id = s.id
                  WHERE ot.enterprise_id = $id_enterprise AND os.id = (
                      SELECT f.id 
                      FROM ot_state f 
                      WHERE f.ot_id = ot.id AND f.date_update = (
                            SELECT MAX(j.date_update)
                            FROM ot_state j
                            WHERE j.ot_id = ot.id
                          ) 
                    ) 
        "; 
        return $this->db->query($query)->result_array(); 
    }

    public function getOrdersApprove()
    {        
        $id = $_SESSION['id'];
        $sql="SELECT  c.enterprise_id 
        FROM client c 
        WHERE c.id = $id";
        $q = $this->db->query($sql)->row_array();
        $id_enterprise = $q['enterprise_id'];

        $query = "SELECT ot.id id, ot.date_admission date, ot.type_service service, c.name component, s.name state, q.email_send
                  FROM ot
                  JOIN enterprise e ON ot.enterprise_id = e.id
                  JOIN component c ON ot.component_id = c.id
                  JOIN ot_state os ON ot.id = os.ot_id
                  JOIN quotation q ON ot.id = q.ot_id
                  JOIN state s ON os.state_id = s.id
                  WHERE s.id = 3 AND ot.enterprise_id = $id_enterprise AND os.id = (
                      SELECT f.id 
                      FROM ot_state f 
                      WHERE f.ot_id = ot.id AND f.date_update = (
                            SELECT MAX(j.date_update)
                            FROM ot_state j
                            WHERE j.ot_id = ot.id
                          ) 
                    ) 
        "; 
        return $this->db->query($query)->result_array(); 
    }

    public function approve($id, $pdf)
    {   
        date_default_timezone_set("America/Santiago");
        $date_update = date("Y-m-d G:i:s");
        $author= $_SESSION['full_name'];
        $user= $_SESSION['id'];
        $message ='La orden de compra '.$id.' fue aprobada por '.$author.' (cliente).';
        
        $query1 = "INSERT INTO notifications (author, message,date,notifications.user_id,state,ot_id) VALUES (?, ?,?,?,?,?)";
        $this->db->query($query1, array($author,$message,$date_update,$user,false,$id));
  

        $sql = "UPDATE quotation SET quotation.correlative_oc  = ? ,approve_client=?,quotation.email_send  = 1, quotation.date_send_email = ?  WHERE ot_id = ?"; //crear campo file en base de datos phpmyadmin
        return $this->db->query($sql, array($pdf,true, $date_update, $id ));
    }

    public function approveEmail($id)
    {
        $query = "SELECT ot.id number_ot, e.name enterprise
        FROM ot
        JOIN enterprise e ON ot.enterprise_id = e.id
        WHERE ot.id = $id
        "; 
        return $this->db->query($query)->result_array(); 
    }

    public function getEmails()
    {        
        $query = "SELECT u.email
                  FROM user u
                  JOIN user_role ur ON u.id = ur.user_id
                  JOIN role r ON ur.role_id = r.id
                  WHERE r.id = 1 OR r.id = 2"; 
        return $this->db->query($query)->result_array(); 
    }
}

