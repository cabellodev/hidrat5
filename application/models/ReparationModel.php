<?php

class ReparationModel extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function getReparationByOrder($ot_id){
        $query= "SELECT ot.date_provider_number, ot.provider_number, r.check_adm check_adm, r.date_assignment, r.check_technical check_technical, r.user_assignment user, r.date_reparation date, r.date_limit date_limit, ot.days_reparation days, r.user_interaction, r.priority
        FROM reparation r
        LEFT JOIN ot ON ot.id = r.ot_id
        WHERE r.ot_id = ? ";
        if($reparation = $this->db->query($query, array($ot_id))->result_array()) return $reparation; else return false;
    }
    
    public function getSubstacksByOrder($ot_id){
        $query = "SELECT sr.id, sr.state, sr.ot_id number_ot, sr.date_assigment date, sr.check_tm, sr.check_at, u.full_name technical_assistant, s.name substask
        FROM subtask_reparation sr
        JOIN user u ON sr.user_id = u.id
        JOIN subtask s ON sr.subtask_id = s.id
        WHERE sr.ot_id = ?"; 
        return $this->db->query($query,array($ot_id))->result();    
    }

    public function getTechnicals()
    {
        $this->db->select('u.id, u.full_name' );
        $this->db->from('user u'); 
        $this->db->join('user_role ur', 'ur.user_id = u.id','left');
        $this->db->where('ur.role_id', 3);
        $this->db->where('u.state', 1);
        return $query = $this->db->get()->result_array();
    }

    public function editReparation($data){
        $user_approve = ''; 
        $date_approve = '';
        $technical_assignment = '';    
        $date_reparation = ''; 
        $user = $_SESSION['full_name'];
        $technical = null;
        $op = 0;
        date_default_timezone_set("America/Santiago");
        $date = date("Y-m-d G:i:s");
        if($data['user_assignment']){
            $technical =$data['user_assignment'];
            $op = 1;
        }else{
            $technical = null;
            $op = 2;
        }

        /*Verify changes in approve reparation*/
        if($data['check_adm'] == '1' AND $data['check_adm_old'] =='false'){
            $date_approve = $date;
            $user_approve = $user;
        }else if($data['check_adm'] == '1' AND $data['check_adm_old'] =='true'){
            $date_approve = $data['date_approve'];
            $user_approve = $data['user_approve'];
        }else {
            $date_approve = '';
            $user_approve = '';
        } 


        /*Verify if technical finalize report */
        if($data['check_technical'] == '1' AND $data['technical_assignment']){
            $technical_assignment = $data['technical_assignment'];
            $date_reparation = $data['date_reparation'];
        }else{
            $technical_assignment = '';
            $date_reparation = '';
        }

        $date_limit = null;
        if($data['date_limit']){$date_limit = $data['date_limit'];};

        $date_assignment = null;
        if($data['date_assignment']){$date_assignment = $data['date_assignment'];};

        $date_reparationR = null;
        if($data['date_reparation']){$date_reparationR = $data['date_reparation'];};

        $days_reparation = null;
        if($data['days_reparation']){$days_reparation = $data['days_reparation'];};

        $datos_r = array(
            'user_assignment' => $data['user_assignment'],
            'check_adm' => $data['check_adm'],   
            'check_technical' => $data['check_technical'],   
            'user_assignment' => $technical,
            'date_reparation' => $date_reparationR,
            'date_limit' => $date_limit,
            'date_assignment' => $date_assignment,
            'priority' => $data['priority'],
            'user_interaction' => json_encode(array(
                'technical_assignment' => $technical_assignment,
                'date_reparation' => $date_reparation,
                'user_modify' => $user,
                'date_modify' => $date,
                'user_approve' => $user_approve,
                'date_approve' => $date_approve,
            )),
        );

        $this->db->where('ot_id', $data['ot_id']);
        if($this->db->update('reparation', $datos_r)){

            if($data['check_adm'] == '1'){
                $datos_ot = array(
                    'date_cellar' => $data['date_reparation'],
                    'date_reparation' =>  $data['date_assignment'],
                    'days_reparation' => $days_reparation,
                    'date_provider_number' => $data['date_provider_number'],
                    'provider_number' => $data['provider_number'],
                );
            }else{
                $datos_ot = array(
                    'date_cellar' => null,
                    'date_reparation' =>  null,
                    'days_reparation' => $days_reparation,
                    'date_provider_number' => $data['date_provider_number'],
                    'provider_number' => $data['provider_number'],
                );
            }

            //update OT
            $this->db->where('id', $data['ot_id']);
            $this->db->update('ot', $datos_ot);

            //insert/update or delete row ot_user
            $this->db->select('*'); $this->db->from('ot_user'); 
            $this->db->where('ot_id', $data['ot_id']);
            $this->db->where('state_id', 4);
            $query = $this->db->get();
            if($op == 1){
                $datos_ot_user = array(
                    'ot_id' => $data['ot_id'],
                    'user_id' => $technical,
                    'state_id' => 4,
                    'date_assignment' => $date,
                );
                if(sizeof($query->result()) == 0){
                    $this->db->insert('ot_user', $datos_ot_user );
                    return true; 
                }else if (sizeof($query->result()) == 1){
                    $this->db->where('ot_id', $data['ot_id']);
                    $this->db->where('state_id', 4);
                    $this->db->update('ot_user', $datos_ot_user );
                    return true;  
                }else{
                    return false;
                }

            }else if($op == 2){
                if(sizeof($query->result()) == 1){
                    $this->db->where('ot_id', $data['ot_id']);
                    $this->db->where('state_id', 4);
                    $this->db->delete('ot_user');
                }
            }
            return true;
        }  else return false;
    }

    public function calculateReparation($data){
        return $this->dayEnd($data);
    }

    public function dayEnd($data){
        $fecha = $data['date_assignment'];
        $dias = $data['days_reparation'];
        $datestart= strtotime($fecha);
        $datesuma = 15 * 86400;
        $diasemana = date('N',$datestart);
        $totaldias = $diasemana+$dias;
        $findesemana = intval( $totaldias/5) *2 ; 
        $diasabado = $totaldias % 5 ; 
        if ($diasabado==6) $findesemana++;
        if ($diasabado==0) $findesemana=$findesemana-2;
    
        $total = (($dias+$findesemana) * 86400)+$datestart ; 
        return (date('Y-m-d', $total));
    }
}
