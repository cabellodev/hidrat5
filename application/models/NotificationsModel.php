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
        $user=$user= $_SESSION['id'];
        $sql = "SELECT u.id id_user
                FROM user u 
                JOIN user_role ur ON u.id = ur.user_id
                WHERE ur.role_id not in (3,4)";
        $collection_users=$this->db->query($sql)->result_array();

        return array( "users"=>$collection_users , "user_id"=>$user);
        
    }




   //subir imagenes
   
}


