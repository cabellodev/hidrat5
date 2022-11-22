<?php
class LocationModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }


    public function getLocation()
    {
        $query = "SELECT * FROM locations";
        return $this->db->query($query)->result();
    }

    public function insertLocation($name)
    {

        $query= "SELECT * FROM locations  WHERE locations.name = ?";
        $result= $this->db->query($query, array($name));
         
        if($result->num_rows() > 0){
            return false; 
        }else{
            
            $query = "INSERT INTO locations (locations.name , locations.state) VALUES (?, ?)";
            return $this->db->query($query, array($name, true));
        }
       
    }

   
    public function updateLocation($name,$id)
    {
        $query= "SELECT * FROM locations WHERE locations.name = ?";
        $result= $this->db->query($query, array($name));

        if($result->num_rows() > 0){
            return false; 
        }else{

            $query = "UPDATE locations SET locations.name= ? WHERE id =?";
            return $this->db->query($query, array($name,  $id));   
        }  
     }
    

    public function changeState($id, $state)
    {
       $query = "UPDATE locations SET locations.state = ? WHERE id = ?";
       return $this->db->query($query, array($state, $id));
    }
 
}