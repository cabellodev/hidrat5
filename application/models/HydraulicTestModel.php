<?php

class HydraulicTestModel extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function getHydraulicTestByOrder($id){

        
        
        $query= "SELECT ht.details , u.full_name , ht.user_assignment, ht.state , ht.user_interaction ,ht.export, ht.config
        FROM hydraulic_test ht
        LEFT JOIN user_role ur ON ur.user_id = ht.user_assignment
        LEFT JOIN user u ON u.id = ur.user_id
        WHERE ht.ot_id = ? AND ht.state = ? ";
        
        return $this->db->query($query, array($id,true))->result(); 

           
      

    }
    public function get_info_ht($id){
        $query= "SELECT extra_info , config FROM hydraulic_test WHERE ot_id = ? ";
         return $this->db->query($query, array($id))->result(); 

    }


    public function editHydraulicTest($id,$data){
        
        $user= $_SESSION['full_name'];
        $date=  date('Y-m-d H:i:s');
        $details="";
        $technical=null;

        $date_approve="";
        $user_approve="";  
        $user_create="";
        $date_create="";
        
        if($data['technical'] == ""){
            $technical = null;
        }else{
            $technical = $data['technical'];
        }
      

        if($technical)

        if($data['approve_technical'] == "true" && $data['check_technical_old'] == "false"){
            $this->setTimeEnd($id);
            $date_create= $date;
            $user_create= $user;

           
        }else  if($data['approve_technical'] == "true" &&  $data['check_technical_old'] == "true"){
                  
                     $date_create= $data['date_create'];
                     $user_create= $data['user_create'];
                    }else {
 
                    $date_create="";
                    $user_create="";

                        }
      
        if($data['approve_admin'] == "true" && $data['check_admin_old'] == "false"){
          
            $date_approve= $date;
            $user_approve= $user;
           
        }else  if($data['approve_admin'] == "true" &&  $data['check_admin_old'] == "true"){
                  
                    $date_approve= $data['date_approve'];
                     $user_approve= $data['user_approve'];
                    }else {
 
                    $date_approve="";
                    $user_approve="";
                        }

        if($_SESSION['rango'] == 1 || $_SESSION['rango'] == 2 ){  // cambiar a rango 2 "admin"
           
        $details= json_encode ( array( 
            "ot"=>$id,
            "date_ht"=> $data['date_ht'],
            "conclusion"=> $data['conclusion'],
            "notes" => $data['notes'],
            "approve_technical" => $data['approve_technical'],
            "approve_admin" => $data['approve_admin'],)
        );

       }else{


          if($_SESSION['rango'] == 3 ){
             
           $details= json_encode ( array( 
            "ot"=>$id,
            "date_ht"=>  date('Y-m-d'),
            "conclusion"=> $data['conclusion'],
            "notes" => $data['notes'],
            "approve_technical" => $data['approve_technical'],
            "approve_admin" => $data['approve_admin'],)
          );

          }

       }

        $user_interaction= json_encode ( array( 
        
            "user_create"=> $user_create,
            "date_create"=> $date_create,
            "user_modify"=> $user,
            "date_modify"=> $date,
            "user_approve"=> $user_approve,
            "date_approve"=> $date_approve,
            )
        );

        $query = "UPDATE hydraulic_test SET details = ? , user_assignment = ? , user_interaction = ? WHERE ot_id = ?";
            return $this->db->query($query, array( $details, $technical, $user_interaction , $id));  
    } 


    public function editInfoHt($id,$data){

        $query = "UPDATE hydraulic_test SET extra_info = ?  WHERE ot_id = ?";
            return $this->db->query($query, array($data,$id));  

    } 


    public function uploadPdf($id, $pdf)
    {   
        $sql = "UPDATE  hydraulic_test SET hydraulic_test.file_ht  = ? WHERE ot_id = ?"; //crear campo file en base de datos phpmyadmin
        return $this->db->query($sql, array($pdf, $id));
        
    }


    public function getPdf($id)
    {   
        $sql= "SELECT file_ht FROM hydraulic_test WHERE ot_id = ? ";
        return $this->db->query($sql, array($id))->result();
        
    }

    public function deletePdf($id)
    {   
        $sql= "UPDATE  hydraulic_test SET hydraulic_test.file_ht  = ? WHERE ot_id = ?";
        return $this->db->query($sql, array(null,$id));
        
    }
    

    public function pdfHidraulicTest($id,$new){
       
          $query = "UPDATE hydraulic_test SET export = ? WHERE ot_id = ?";
          return $this->db->query($query, array($new,$id));  
    }

   

    public function  save_config($id,$data){

        $config= json_encode ( array( 
            "config_speed"=> $data['config_speed'],
            "config_presion"=> $data['config_presion'],
            "config_caudal" => $data['config_caudal'],
            "config_time" => $data['config_time'],
        ));
       
        $query = "UPDATE hydraulic_test SET config = ? WHERE ot_id = ?";
        return $this->db->query($query, array($config,$id));  
  }


  public function setTimeEnd($ot_id){
    date_default_timezone_set("America/Santiago");
    $date_end = date("Y-m-d G:i:s");
    $date1 = new DateTime($date_end);
   

    $query= "SELECT ht.time_init, ht.hours
    FROM hydraulic_test ht
    WHERE ht.ot_id = ?";
    $hydraulicTest = $this->db->query($query, array($ot_id))->result_array(); 

    $hoursData = $hydraulicTest[0]['hours'];


    $date_init = $hydraulicTest[0]['time_init'];
    $date2 = new DateTime($date_init);

    $interval = $date1->diff($date2);

    $year = (int)$interval->format('%y');
    $month = (int)$interval->format('%m');
    $day = (int)$interval->format('%d');
    $hour = (int)$interval->format('%h');
    $minute = (int)$interval->format('%i');
    $second = (int)$interval->format('%s seconds');

    if($minute != 0){
        $minute = $minute * 60;
    }

    if($hour != 0){
        $hour = $hour * 3600;
    }

    if($day != 0){
        $day = $day * 86400;
    }

    $meses = 0;
    if($month != 0){ 
    /*     $month = $day * 86400; */
        $año = date("Y", strtotime($date_init));
        $mes = date("m", strtotime($date_init));

        for($i=0; $i<$month; $i++){
            $aux = (int)$mes + $i;
            $cantDays = date('t', strtotime($año.'-'.$aux.'-05'));
            $meses = $meses + ($cantDays*86400);
        }
    }

    $suma = $minute + $hour + $day + $meses + $second;
    $hoursTotal = ($suma/3600) + $hoursData;

    $datos = array(
        'time_end' => $date_end,
        'time_init' => null,
        'aux' => null,
        'hours' => $hoursTotal,
    );
    $this->db->where('ot_id', $ot_id);
    if($this->db->update('hydraulic_test', $datos)) return true; else return false;
}
      

    
}