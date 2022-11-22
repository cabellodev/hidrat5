<?php
class UserModel extends CI_Model
{

   public function __construct()
   {
      parent::__construct();
   }


   public function createUser($name, $email, $rut, $hash, $rango)
   {
      $query = "INSERT INTO user (nombre,password_hash,estado,user.range,rut,email) VALUES (?, ?, ?, ?,?,?)";
      return $this->db->query($query, array($name, $hash, true, $rango, $rut, $email));
   }
   
   public function getUsers()
   {
      $query = "SELECT id,rut,nombre,estado,email,user.range FROM user";
      return $this->db->query($query)->result();
   }
   public function editUser($name, $email, $rut, $rango)
   {
      $query = "UPDATE user SET nombre= ?,email=?,user.range=? WHERE rut =?";
      return $this->db->query($query, array($name, $email, $rango, $rut));
   }

   public function changeState($id, $state)
   {
      $query = "UPDATE user SET estado = ? WHERE rut = ?";
      return $this->db->query($query, array($state, $id));
   }


}
