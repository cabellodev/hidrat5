<?php

class AprobationModel extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function getAprobationByOrder($id){
      
        $query= "SELECT user_interaction , approve_client , date_quotation , date_send_qt , number_qt ,date_send_email 
        FROM quotation
        WHERE ot_id = ? ";
        
        return $this->db->query($query, array($id))->result(); 

    }
   

    public function editAprobation($id,$data){
        $sql_ot = "UPDATE ot SET date_quotation = ? WHERE id = ?";
        $this->db->query($sql_ot, array( $data['date_ap'], $id));  
       
        $user= $_SESSION['full_name'];
        $date=  date('Y-m-d G:i:s');

        $date_approve="";
        $user_approve="";
      
        if($data['approve_client'] == "true" && $data['check_client_old'] == "false"){
      
            $date_approve= $date;
            $user_approve= $user;
           
        }else  if($data['approve_client'] == "true" &&  $data['check_client_old'] == "true"){
                  
                    $date_approve= $data['date_approve'];
                     $user_approve= $data['user_approve'];
                    }else {
 
                    $date_approve="";
                    $user_approve="";
                        }

    
        $user_interaction= json_encode ( array( 
            "user_modify"=> $user,
            "date_modify"=> $date,
            "user_approve"=> $user_approve,
            "date_approve"=> $date_approve,
            )
        );  
        $approve_client=false;
        if($data['approve_client']=="true"){ $approve_client= true;} 
        
        $query = "UPDATE quotation SET approve_client = ? ,date_send_qt= ? , number_qt= ?  , date_quotation = ? ,user_interaction = ?  WHERE ot_id = ?";
            return $this->db->query($query, array( $approve_client, $data['date_ap'] ,$data['qt_number'],$data['date_send'], $user_interaction, $id));  
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