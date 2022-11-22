<?php
class SellerModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function  getApproveTechnicalReport () { 
        

        $query = "SELECT ot.id number_ot, ot.date_admission date, ot.priority priority, ot.description description, ot.type_service service, e.name enterprise, c.name component, s.name state ,tr.details,tr.user_interaction
        FROM ot
        JOIN enterprise e ON ot.enterprise_id = e.id
        JOIN component c ON ot.component_id = c.id
        JOIN ot_state os ON ot.id = os.ot_id
         JOIN technical_report tr ON ot.id = tr.ot_id
        JOIN state s ON os.state_id = s.id
        WHERE s.id > 2  AND os.id = (
            SELECT f.id 
            FROM ot_state f 
            WHERE f.ot_id = ot.id AND f.date_update = (
                  SELECT MAX(j.date_update)
                  FROM ot_state j
                  WHERE j.ot_id = ot.id
                ) 
          ) 
        "; 

     return  $this->db->query($query)->result(); 
    
     }
     
     public function getOrdersQuotation () { 
        
        $query = "SELECT ot.id number_ot, ot.date_admission date, ot.priority priority, ot.description description, ot.type_service service, e.name enterprise, c.name component, s.name state, approve_client
        FROM ot
        JOIN enterprise e ON ot.enterprise_id = e.id
        JOIN component c ON ot.component_id = c.id
        JOIN ot_state os ON ot.id = os.ot_id
        JOIN quotation q ON ot.id = q.ot_id
        JOIN state s ON os.state_id = s.id
        WHERE s.id=3 AND os.id = (
            SELECT f.id 
            FROM ot_state f 
            WHERE f.ot_id = ot.id AND f.date_update = (
                  SELECT MAX(j.date_update)
                  FROM ot_state j
                  WHERE j.ot_id = ot.id
                ) 
          ) 
        "; 

     return $this->db->query($query)->result(); 
    
     }

     public function orderAllEnterprise () { 
  
      $query = "SELECT ot.id number_ot,c.name component,q.correlative_oc, ot.date_admission date, ot.priority priority, ot.description description, ot.type_service service, e.name enterprise,e.id id_enterprise, c.name component, s.name state, approve_client
      FROM ot
      JOIN enterprise e ON ot.enterprise_id = e.id
      JOIN component c ON ot.component_id = c.id
      JOIN ot_state os ON ot.id = os.ot_id
      JOIN quotation q ON ot.id = q.ot_id
      JOIN state s ON os.state_id = s.id
      WHERE  os.id = (
          SELECT f.id 
          FROM ot_state f 
          WHERE f.ot_id = ot.id AND f.date_update = (
                SELECT MAX(j.date_update)
                FROM ot_state j
                WHERE j.ot_id = ot.id
              ) 
        ) 
      "; 

   return $this->db->query($query)->result(); 
  
   }
     

    

      public function ordersEnterprise ($data) { 
        $id=$data['id_enterprise']; // de empresa 
        $query = "SELECT ot.id number_ot,c.name component,q.correlative_oc, ot.date_admission date, ot.priority priority, ot.description description, ot.type_service service, e.name enterprise,e.id id_enterprise, c.name component, s.name state, approve_client
        FROM ot
        JOIN enterprise e ON ot.enterprise_id = e.id
        JOIN component c ON ot.component_id = c.id
        JOIN ot_state os ON ot.id = os.ot_id
        JOIN quotation q ON ot.id = q.ot_id
        JOIN state s ON os.state_id = s.id
        WHERE ot.enterprise_id =? AND os.id = (
            SELECT f.id 
            FROM ot_state f 
            WHERE f.ot_id = ot.id AND f.date_update = (
                  SELECT MAX(j.date_update)
                  FROM ot_state j
                  WHERE j.ot_id = ot.id
                ) 
          ) 
        "; 

     return $this->db->query($query,array($id))->result(); 
    
     }
     


     
     public function changeState($id, $state,$states)
    {   

      date_default_timezone_set("America/Santiago");
      $date = date("Y-m-d G:i:s");
      $author= $_SESSION['full_name'];
      $user= $_SESSION['id'];
      $range=1;
      $message="";
      if($state == 1){  $message ='La orden de compra '.$id.' fue aprobada por '.$author.' (ventas).'; }else{  $message ='La orden de compra '.$id.' debio ser reevaluada por'.$author.' (ventas).';}
      
      $query1 = "INSERT INTO notifications (author, message,date,notifications.user_id,state,ot_id, rango,states) VALUES (?, ?,?,?,?,?,?,?)";
      $this->db->query($query1, array($author,$message,$date,$user,false,$id,$range,$states)); // autor, mensaje,fecha,id_usuario , no_visto, id de ot , tipo_usuario (1 , venta , 2 cliente)

       $query = "UPDATE quotation SET approve_client = ? WHERE ot_id = ?";
       return $this->db->query($query, array($state, $id));
    }

    public function uploadOC($id, $pdf)
    {   
        $sql = "UPDATE  quotation SET quotation .correlative_oc  = ? WHERE ot_id = ?"; //crear campo file en base de datos phpmyadmin
        return $this->db->query($sql, array($pdf, $id));
        
    }


    public function getOC($id)
    {   
        $sql= "SELECT correlative_oc FROM quotation  WHERE ot_id = ? ";
        return $this->db->query($sql, array($id))->result();
        
    }

    public function deleteOC($id)
    {   
        $sql= "UPDATE  quotation  SET quotation .correlative_oc  = ? WHERE ot_id = ?";
        return $this->db->query($sql, array(null,$id));
        
    }

}

