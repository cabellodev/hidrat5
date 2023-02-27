<?php


class NotificationsTechnicalModel extends CI_Model
{

    
    public function __construct()
    {
            parent::__construct();
    }



    public function createNotification($data){
       

       
        $sql = "SELECT * FROM notifications_technical WHERE user =? ";
        $result= $this->db->query($sql ,$data['user']);

        if(sizeof($result->result()) == 0){
              $aux = array('user'=>$data['user'],
                           'messages'=>$data['messages']
                           );

             return $this->db->insert('notifications_technical',$aux);

        }else{
            $this->db->where('user',$data['user']);
            return $this->db->update('notifications_technical',array('messages'=>$data['messages']));
            
        }

    }

    public function changeState($data){

         $user= $_SESSION['id'];
         $this->db->where('user',$user);
         return $this->db->update('notifications_technical',array('messages'=>$data['message']));


    }


    public function  getNotifications(){

        $sql = "SELECT * FROM notifications_technical";
        return $this->db->query($sql)->result_array();

    }


    public function  getNotificationsByTechnical(){

         $user = $_SESSION['id'];
        $sql = "SELECT * FROM notifications_technical WHERE user=?";
        return $this->db->query($sql,array($user))->result_array();

       
    }
   



    





   //subir imagenes
   
}


