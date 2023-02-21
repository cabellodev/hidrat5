<?php

class EvaluationModel extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function getEvaluationByOrder($id){
        
        
        $query= "SELECT e.details ,o.problem, u.full_name , e.user_assignment,e.state,e.export,e.user_interaction,e.priority
        FROM evaluation e
        LEFT JOIN  ot o ON o.id =e.ot_id
        LEFT JOIN user_role ur ON ur.user_id = e.user_assignment
        LEFT JOIN user u ON u.id = ur.user_id
        WHERE e.ot_id = ? AND e.state = ? ";
        
        return $this->db->query($query, array($id,true))->result(); 
    }

    public function getLocationByOrder($id){
        
        
        $query= "SELECT ots.location_id , l.name name_location  
                 FROM ot_location ots
                 JOIN locations l ON ots.location_id = l.id
        
          WHERE ots.id = (
        
                        SELECT MAX(otl.id)
                        FROM ot_location otl 
                        WHERE otl.ot_id = ?
                    )"
                ;
        
        return $this->db->query($query, $id )->result(); 
    }


    public function getSubstacksByOrder($id){
        $query = "SELECT se.id, se.state, se.ot_id number_ot, se.date_assigment date, se.check_tm, se.check_at, u.full_name technical_assistant, s.name substask
        FROM subtask_evaluation se
        JOIN user u ON se.user_id = u.id
        JOIN subtask s ON se.subtask_id = s.id
        WHERE se.ot_id = ?"; 
        return $this->db->query($query,array($id))->result();  
    }

    public function getSubstaksReparation($id){
        $query = "SELECT sr.id, sr.state, sr.ot_id number_ot, sr.date_assigment date, sr.check_tm, sr.check_at, u.full_name technical_assistant, s.name substask
        FROM subtask_reparation sr
        JOIN user u ON sr.user_id = u.id
        JOIN subtask s ON sr.subtask_id = s.id
        WHERE sr.ot_id = ?"; 
        return $this->db->query($query,array($id))->result();  
    } 


    public function editEvaluation($id,$data){

        
         $location = 0;
        if($data['userAdmin'] == 0){

            if($data['location']==""){
                $location = 1;
            }else{
                $location = $data['location'];
            }
            
            
            $datos_ot_location = array(
                'ot_id' => $id,
                'location_id' => $location,
                'user_id' => $this->session->userdata('id')
            );
    
            $this->db->insert('ot_location', $datos_ot_location);
        }        

        $user= $_SESSION['full_name'];
        date_default_timezone_set("America/Santiago");
        $date=  date('Y-m-d H:i:s');
        $date_priority=  null;


        $date_approve="";
        $user_approve="";
        $user_create="";
        $date_create="";
        $priority = $data['priority'];

    
        if($data['approve_admin'] == "true"){
      
            $date_approve= $date;
            $user_approve= $user;
           
        }
        $technical = $this->session->userdata('id');
        if($data['technical']){
            $technical = $data['technical'];
            $date_priority=  date('Y-m-d G:i:s');
        };

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

        
        $details= json_encode ( array( 
            "ot"=>$id,
            "date_evaluation"=> $data['date_evaluation'],
            "description"=> $data['description'],
            "notes" => $data['notes'],
            "approve_technical" => $data['approve_technical'],
            "approve_admin" => $data['approve_admin']
             )
        );

        $user_interaction= json_encode ( array( 
        
            "user_create"=> $user_create,
            "date_create"=> $date_create,
            "user_modify"=> $user,
            "date_modify"=> $date,
            "user_approve"=> $user_approve,
            "date_approve"=> $date_approve,
            )
        );

        

            $query = "UPDATE evaluation SET details = ? , user_assignment = ? , user_interaction = ? , priority = ? , date_priority = ? WHERE ot_id = ?";
            return $this->db->query($query, array($details,$technical,$user_interaction,$priority,$date_priority,$id)); 
        
       
    }  


    public function pdfEvaluation($id,$new){
  //  unlink('./'.$old);
    $query = "UPDATE evaluation SET export = ? WHERE ot_id = ?";
    return $this->db->query($query, array($new,$id));  
    }

    public function setTimeEnd($ot_id){
        date_default_timezone_set("America/Santiago");
        $date_end = date("Y-m-d G:i:s");
        $date1 = new DateTime($date_end);
        $year1 = $date1->format('Y');
        $month1 = $date1->format('m');
        $day1 = $date1->format('d');
    
        $query= "SELECT ev.time_init, ev.hours
        FROM evaluation ev
        WHERE ev.ot_id = ?";
        $evaluation = $this->db->query($query, array($ot_id))->result_array(); 
    
        $hoursData = $evaluation [0]['hours'];
    
        $diasferiados = [ '' ];
        $date_init = $evaluation [0]['time_init'];
        $date2 = new DateTime($date_init);

        $year2 = $date2->format('Y');
        $month2 = $date2->format('m');
        $day2 = $date2->format('d');

    
        $fechafin = $year1.'-'.$month1.'-'.$day1;
        $fechainicio = $year2.'-'.$month2.'-'.$day2;
        $fechainicio = strtotime($fechainicio);
        $fechafin = strtotime($fechafin);


        // Incremento en 1 dia
        $diainc = 24*60*60;
       
        // Arreglo de dias habiles, inicianlizacion
        $diashabiles = array();
       
        // Se recorre desde la fecha de inicio a la fecha fin, incrementando en 1 dia
        for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc) {
                // Si el dia indicado, no es sabado o domingo es habil
                if (!in_array(date('N', $midia), array(6,7))) { // DOC: http://www.php.net/manual/es/function.date.php
                        // Si no es un dia feriado entonces es habil
                        if (!in_array(date('Y-m-d', $midia), $diasferiados)) {
                                array_push($diashabiles, date('Y-m-d', $midia));
                        }
                }
        }
       
        $dias = count($diashabiles);

        $datos = array(
            'time_end' => $date_end,
            'time_init' => null,
            'aux' => null,
            'hours' => $dias+$hoursData ,
        );
        $this->db->where('ot_id', $ot_id);
        if($this->db->update('evaluation', $datos)) return true; else return false;
    }
          





}