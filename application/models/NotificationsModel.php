<?php


class NotificationsModel extends CI_Model
{

    
    public function __construct()
    {
            parent::__construct();
    }

    //traer imagenes por id 
    public function get_notifications()

    {   

        $user= $_SESSION['id'];
        $sql1 = "SELECT * FROM notifications WHERE state = ? and notifications.user_id not in (?)";
        $new_messages= $this->db->query($sql1, array(false,$user))->result_array();
        
        
        $sql = "SELECT * FROM notifications ORDER BY notifications.date DESC ";
        $notifications= $this->db->query($sql)->result_array();

        return array( "new_messages"=>  $new_messages, "notifications"=>$notifications ,"id_user"=>$user);
        
    }
 


    public function change_notification($id,$data)
    {   
       
       $query = "UPDATE notifications SET state = ?  ,states = ? WHERE id_notification = ?";
       return $this->db->query($query, array(true,$data['states'],$id));

    }


    public function get_user_notifications()
    {   
        $user= $_SESSION['id'];
        $sql = "SELECT u.id id_user
                FROM user u 
                JOIN user_role ur ON u.id = ur.user_id
                WHERE ur.role_id not in (3,4)";
        $collection_users=$this->db->query($sql)->result_array();

        return array( "users"=>$collection_users , "user_id"=>$user);
        
    }


    public function notifications_billing($data)
    {   
        $message="";
     if($data['reason']==1){
        $message='La orden '.$data['ot'].' cambio a facturado por '.$_SESSION['full_name'].'';
     }else if($data['reason']==2){
        $message='La orden '.$data['ot'].' se cerro por devolución. Hecho por '.$_SESSION['full_name'].'';
     }
     else if($data['reason']==3){
        $message='La orden '.$data['ot'].' cerrada por cortesía del cliente. Hecho por '.$_SESSION['full_name'].'';
     }else if($data['reason']==10){
        $message='La orden '.$data['ot'].' a cambiado estado de cierre. Hecho por '.$_SESSION['full_name'].'';

     }

      date_default_timezone_set("America/Santiago");

      $notification = array(
        'author'=>$_SESSION['full_name'],
        'message'=> $message,
        'date'=>date("Y-m-d G:i:s"),
        'user_id'=> $_SESSION['id'],
        'state'=> false,
        'ot_id'=> $data['ot'],
        'rango'=> 1,
        'states'=> $data['states']
      );
      

      $query = "INSERT INTO notifications (author, message,date,notifications.user_id,state,ot_id, rango,states) VALUES (?, ?,?,?,?,?,?,?)";
      
      return $this->db->query($query,$notification); 
    }




    public function change_all_states($data)
    {   
       $success=true;
       foreach($data as $value){    
         $query = "UPDATE notifications SET state = ?,states = ? WHERE id_notification = ?";
          if($this->db->query($query, array(true,$value['states'],$value['id']))){
             $success=true;
          }else{
            $success=false;
          }
       }
       return $success;
    }





   }


