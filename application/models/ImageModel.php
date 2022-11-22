<?php


class ImageModel extends CI_Model
{

    
    public function __construct()
    {
            parent::__construct();
    }

    //traer imagenes por id 
    public function getImagesByOT($ot_number)
    {
        $sql = "SELECT * FROM images WHERE ot_id =?"  ;
        return $this->db->query($sql, array($ot_number))->result();
        

    }

   //subir imagenes
    public function insertImage($data)
    {   

        $query= "SELECT * FROM images WHERE images.name = ? AND images.ot_id = ?";
        $result= $this->db->query($query, array("name"=> $data["name"], "ot_id"=> $data["id"]));
         

        $data = array( 
            "name" => $data["name"],
            "files" => null,
            "ot_id" => $data["id"],    
        );
        try {
            if($result->num_rows() == 0){
            $this->db->insert("images", $data);
            $id = $this->db->insert_id();
            $s = array(
                "id" => $id,
                "status" => "success"
            );
            return $s;
            }
        } catch (Exception $e) {
            $s = array(
                "id" => null,
                "status" => "fail"
            );
            return $s;
        }
    }


    public function imageUpload($id, $image)
    {  
       

        $data = array(
            "files" => $image, 
        );
    
        try {
            $this->db->where('id', $id);
            $this->db->update("images", $data);
            return "success";
        } catch (Exception $e) {
            return "fail";
        }
    }
    

    public function editImagen($data, $id)
    {
        

        $data = array(
            "name" => $data["name"],
        );
        try {
          if($data["name"] != "") { 
            
            $this->db->where('id', $id);
            $this->db->update("images", $data);
            $s = array(
                "id" => $id,
                "status" => "success"
            );
            return $s;

        }else{
            $s = array(
                "id" => $id,
                "status" => "success"
            );
            return $s;

        }
        } catch (Exception $e) {
            $s = array(
                "id" => null,
                "status" => "fail"
            );
            return $s;
        }
    }


    public function insert_Image($id, $image)
    {   
        $data =array (
           'name'=>'---',
           'files'=>$image,
           'ot_id'=>$id

        );

        try {
            
            $this->db->insert("images", $data);
            $id = $this->db->insert_id();
            return $s ="success";
            
        } catch (Exception $e) {
            $s = array(
                "id" => null,
                "status" => "fail"
            );
            return $s;
        }
    }

  
       
    public function deleteImage($id)
    {
        $sql = "DELETE 
                FROM images
                WHERE id= ?";
        return $this->db->query($sql, array($id));

     
    }
    

}


