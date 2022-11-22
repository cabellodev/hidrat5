<?php
class TechnicalAssistantModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getSubstaksReparation(){
        $user= $_SESSION['id'];
        $query = "SELECT sr.subtask_id, sr.state, sr.ot_id number_ot, sr.date_assigment date, sr.check_tm, sr.check_at, s.name substask,
        sr.aux, sr.time_init, sr.time_end
        FROM subtask_reparation sr
        JOIN subtask s ON sr.subtask_id = s.id
        WHERE sr.user_id = ? && sr.state = ? && sr.check_tm = ?"; 
        return $this->db->query($query, array($user, 1, 0))->result();  
    } 

    public function getSubstaksEvaluation(){
        $user= $_SESSION['id'];
        $query = "SELECT sr.subtask_id, sr.state, sr.ot_id number_ot, sr.date_assigment date, sr.check_tm, sr.check_at, s.name substask,
        sr.aux, sr.time_init, sr.time_end
        FROM subtask_evaluation sr
        JOIN subtask s ON sr.subtask_id = s.id
        WHERE sr.user_id = ? && sr.state = ? && sr.check_tm = ?"; 
        return $this->db->query($query, array($user, 1, 0))->result();  
    } 


    public function approve($data){
        date_default_timezone_set("America/Santiago");
        $date_update = date("Y-m-d G:i:s");
        $res = $this->setTimeEnd($data['ot_id'], $data['id'], $data['name']);
        if($res = true){
            $datos_substaks = array(
                'check_at' => '1',
                'date_end' => $date_update,
            );
    
            $this->db->where('ot_id', $data['ot_id']);
            $this->db->where('subtask_id', $data['id']);
    
            if($this->db->update($data['name'], $datos_substaks)) return true; else return false;
        }else{
            return false;
        }
    } 


    public function setTimeEnd($ot_id, $substask_id, $table){
        date_default_timezone_set("America/Santiago");
        $date_end = date("Y-m-d G:i:s");
        $date1 = new DateTime($date_end);
       
 
        $query= "SELECT tr.time_init, tr.hours
        FROM $table tr
        WHERE tr.ot_id = ? AND tr.subtask_id = ?";
        $technicalReport = $this->db->query($query, array($ot_id, $substask_id))->result_array(); 

        $hoursData = $technicalReport[0]['hours'];


        $date_init = $technicalReport[0]['time_init'];
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
        $this->db->where('subtask_id', $substask_id);
        if($this->db->update($table, $datos)) return true; else return false;
    }


    public function getCounterData($user){

        
        $query1 = "SELECT sr.subtask_id, sr.state, sr.ot_id number_ot, sr.date_assigment date, sr.check_tm, sr.check_at, s.name substask
        FROM subtask_reparation sr
        JOIN subtask s ON sr.subtask_id = s.id
        WHERE sr.user_id = ? && sr.state = ? && sr.check_tm = ? "; 
        $subtask_rep = $this->db->query($query1, array($user, 1, 0))->result();  

        $query2 = "SELECT se.subtask_id, se.state, se.ot_id number_ot, se.date_assigment date, se.check_tm, se.check_at, s.name substask
        FROM subtask_evaluation se
        JOIN subtask s ON se.subtask_id = s.id
        WHERE se.user_id = ? && se.state = ? && se.check_tm = ? "; 
        $subtask_ev = $this->db->query($query2, array($user, 1, 0))->result();
        
         return array( "subtask_rep" => $subtask_rep ,"subtask_ev"=> $subtask_ev );



    } 
}