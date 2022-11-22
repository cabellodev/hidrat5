<?php
class SubtaskModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }


    public function getSubtask()
    {
        $query = "SELECT * FROM subtask";
        return $this->db->query($query)->result();
    }

    public function insertSubtask($name)
    {
        $query= "SELECT * FROM subtask  WHERE subtask.name = ?";
        $result= $this->db->query($query, array($name));
         
        if($result->num_rows() > 0){
            return false; 
        }else{
            
            $query = "INSERT INTO subtask (subtask.name, subtask.state) VALUES (?, ?)";
             return $this->db->query($query, array($name, true));
        }
    }

    public function updateSubtask($name,$id)
    {   
        $query= "SELECT * FROM subtask WHERE subtask.name = ?";
        $result= $this->db->query($query, array($name));

        if($result->num_rows() > 0){
            return false; 
        }else{

            $query = "UPDATE subtask SET subtask.name= ? WHERE id =?";
            return $this->db->query($query, array($name, $id));
        }  
       
     }
    

    public function changeState($id, $state)
    {
       $query = "UPDATE subtask SET subtask.state = ? WHERE id = ?";
       return $this->db->query($query, array($state, $id));
    }
 
}
