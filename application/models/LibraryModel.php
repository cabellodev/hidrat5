<?php
class LibraryModel extends CI_Model
{

   public function __construct()
   {
      parent::__construct();
   }

   public function create_document($datos)
   {
            $post_data = array( "name" => $datos['name'],
                          "tags"=>$datos["tags"]
                        );
                          
            $this->db->insert('documentations',$post_data);
            return $this->db->insert_id();              
         
   }
   

   public function create_tag($datos)
   {  

     $sql = "SELECT * FROM tags WHERE tags.name= ?";
     $tags_repeat = $this->db->query($sql, array($datos['new_tag']));
     
     if(sizeof($tags_repeat->result()) > 0){
        return false;
     }else{
      $query = "INSERT INTO tags (tags.name) VALUES (?)";
      return $this->db->query($query, array($datos['new_tag']));
     }
   }


   public function update_document($pdf,$id)
   {
      $query = "UPDATE documentations  SET documentations.file_name = ? WHERE id_document = ?";
      return $this->db->query($query, array($pdf,$id));
   }

   public function edit_tag($datos)
   {  
      $sql = "SELECT * FROM tags WHERE tags.name= ?";
      $tags_repeat = $this->db->query($sql, array($datos['new_name']));

      if(sizeof($tags_repeat->result()) > 0){
         return false;
      }else{
         $query = "UPDATE tags  SET name= ? WHERE id_tag= ?";
         return $this->db->query($query, array($datos['new_name'],$datos['id']));
      }
   }


   public function update_tags($datos)
   {  
    
      $query = "UPDATE documentations SET documentations.tags= ? WHERE id_document= ?";
      return $this->db->query($query, array($datos['tags'],$datos['id']));
   }


   public function delete_tags($datos)
   {

       
      $query = "DELETE FROM tags WHERE name = ?";
     
      return $this->db->query($query, array($datos['tag_delete']));
   }

  
   public function get_tags()
   {
      $query = "SELECT t.name, t.id_tag from tags t ORDER BY t.name ASC";
      return $this->db->query($query)->result_array();
   }

   public function get_document()
   {
   
      $query = "SELECT * from documentations ";
      return $this->db->query($query)->result_array();

   }
   

   public function edit_document($datos)
   {  
         $query = "UPDATE documentations  SET documentations.name= ? , tags = ?  WHERE id_document= ?";
         return $this->db->query($query, array($datos['name'], $datos['tags'],$datos['id']));
   }

   public function  change_state_documents($datos){
      $query = "UPDATE documentations  SET documentations.state= ?   WHERE id_document= ?";
      return $this->db->query($query, array($datos['state'],$datos['id']));

   }

   //querys for technical master
   public function get_document_active()
   {
      $query = "SELECT * from documentations WHERE documentations.state=?";
      return $this->db->query($query , array(0))->result_array();
   }







   
     
   }







   



   

  


