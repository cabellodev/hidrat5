<?php
class PeticionModel extends CI_Model
{

   public function __construct()
   {
      parent::__construct();
   }


   public function createPeticion ($name, $email, $phone, $message)
   {
      $query = "INSERT INTO peticiones (nombre_peticion,correo_peticion,telefono_peticion,texto_peticion) VALUES (?, ?, ?, ?)";
      $this->db->query($query, array($name, $email, $phone, $message));
      $id = $this->db->insert_id();
      
      $data_state = array(
         'id_peticion' => $id , 
         'id_estado' => 1,
         'update_date' => date('Y-m-d H:i:s')
    );

     $this->db->insert('peticion_estado',$data_state);
     
     return true ;
     

   }

   public function getPeticion() {
   
      $query= "SELECT p.id_peticion ,p.nombre_peticion , p.correo_peticion, p.telefono_peticion , p.texto_peticion , e.nombre_estado,e.id_estado,e.sigla
              FROM peticion_estado PE INNER JOIN peticiones p ON PE.id_peticion = p.id_peticion INNER JOIN estado e 
              ON e.id_estado = PE.id_estado WHERE PE.update_date= (SELECT MAX(PE2.update_date)
                                                                   FROM peticion_estado PE2  
                                                                   WHERE PE2.id_peticion = p.id_peticion)
      ORDER BY
      p.id_peticion DESC"; 
      return $this->db->query($query)->result();
   }
   
   public function editPeticion($id , $name , $email ,$phone ,$message) { 
      
      $query= "UPDATE peticiones  SET nombre_peticion =? , correo_peticion=? , telefono_peticion=? , texto_peticion=? WHERE id_peticion = ?";

      return $this->db->query($query , array ($name , $email, $phone, $message , $id ));
      }

   public function getEstados(){ 
       $query ="SELECT e.id_estado, e.nombre_estado ,e.sigla FROM estado e";
       return $this->db->query($query)->result();

   }

   

}
