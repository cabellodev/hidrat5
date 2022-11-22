<?php
class ComponentModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }


    public function getComponent()
    {
        $query = "SELECT * FROM component";
        return $this->db->query($query)->result();
    }

    public function insertComponent($name)
    {
        $query= "SELECT * FROM component  WHERE component.name = ?";
        $result= $this->db->query($query, array($name));
         
        if($result->num_rows() > 0){
            return false; 
        }else{
            
            $query = "INSERT INTO component (component.name , component.state) VALUES (?, ?)";
            return $this->db->query($query, array($name, true));
        }

    }

   
    public function updateComponent($name,$id)
    {   
        $query= "SELECT * FROM component WHERE component.name = ?";
        $result= $this->db->query($query, array($name));

        if($result->num_rows() > 0){
            return false; 
        }else{

            $query = "UPDATE component SET component.name= ?WHERE id=?";
            return $this->db->query($query, array($name,  $id));  
        }  
       
     }
    

    public function changeState($id, $state)
    {
       $query = "UPDATE component SET component.state = ? WHERE id = ?";
       return $this->db->query($query, array($state, $id));
    }
 
}