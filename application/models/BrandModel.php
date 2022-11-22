<?php
class BrandModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }


    public function getBrand()
    {
        $query = "SELECT * FROM brand ";
        return $this->db->query($query)->result();
    }

    public function insertBrand($name)
    {
            $query= "SELECT * FROM brand  WHERE brand.name = ?";
            $result= $this->db->query($query, array($name));
             
            if($result->num_rows() > 0){
                return false; 
            }else{
                $query = "INSERT INTO brand (brand.name , brand.state) VALUES (?, ?)";
                return  $this->db->query($query, array($name, true));
            }
    }

   
    public function updateBrand($name,$id)
        
    {
            $query= "SELECT * FROM brand  WHERE brand.name = ?";
            $result= $this->db->query($query, array($name));

            if($result->num_rows() > 0){
                return false; 
            }else{
                    
            $query = "UPDATE brand SET brand.name= ? WHERE id=?";
            return $this->db->query($query, array($name, $id));
            }
       
                 
        
    }
    

    public function changeState($id, $state)
    {
       $query = "UPDATE brand  SET brand.state = ? WHERE id = ?";
       return $this->db->query($query, array($state, $id));
    }
 
}