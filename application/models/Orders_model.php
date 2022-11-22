<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Orders_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getOrder($id)
    {
        $query = "SELECT * FROM ot_location WHERE ot_id = ?";
        $result = $this->db->query($query, array($id));

        if(sizeof($result->result()) >= 1){
            $query = "SELECT ot.id number_ot, ot.problem , ot.config, ot.provider_number, ot.date_provider_number ,ot.days_quote days_quote, ot.date_admission date, ot.priority priority, ot.description description, ot.type_service service,  e.name enterprise, l.name location, c.name component, s.name state
            FROM ot
            LEFT JOIN enterprise e ON ot.enterprise_id = e.id
            LEFT JOIN component c ON ot.component_id = c.id
            LEFT JOIN ot_state os ON ot.id = os.ot_id
            LEFT JOIN state s ON os.state_id = s.id
            LEFT JOIN ot_location ol ON ot.id = ol.ot_id
            LEFT JOIN locations l ON ol.location_id = l.id
            WHERE os.id = (
                SELECT f.id 
                FROM ot_state f 
                WHERE f.ot_id = ".$id." AND f.date_update = (
                      SELECT MAX(j.date_update)
                      FROM ot_state j
                      WHERE j.ot_id = ".$id."
                    ) 
              )   AND
              ol.id =  (
                  SELECT MAX(j.id)
                  FROM ot_location j
                  WHERE j.ot_id = ".$id."
              )          
            "; 
            return $this->db->query($query)->row_array();
        }else{
            $query = "SELECT ot.id number_ot, ot.config, ot.provider_number, ot.date_provider_number ,ot.days_quote days_quote, ot.date_admission date, ot.priority priority, ot.description description, ot.type_service service, e.name enterprise, c.name component, s.name state
            FROM ot
            LEFT JOIN enterprise e ON ot.enterprise_id = e.id
            LEFT JOIN component c ON ot.component_id = c.id
            LEFT JOIN ot_state os ON ot.id = os.ot_id
            LEFT JOIN state s ON os.state_id = s.id
            WHERE os.id = (
                SELECT f.id 
                FROM ot_state f 
                WHERE f.ot_id = ".$id." AND f.date_update = (
                      SELECT MAX(j.date_update)
                      FROM ot_state j
                      WHERE j.ot_id = ".$id."
                    ) 
              )
            "; 
            return $this->db->query($query)->row_array();
        }
    }

    public function getStates()
    {
        return $query=$this->db->get('state')->result_array();
    }


    public function autoincrementID() { 
        $query = "SELECT MAX(ot.id) as autoincrement  FROM ot";
        return $this->db->query($query)->result(); 

    }

    public function exist_ot_number($id) { 

        $this->db->select('*'); $this->db->from('ot'); $this->db->where('id', $id);
        $query = $this->db->get();
        if(sizeof($query->result()) != 0){
            return true;
        }else{
            return false;
        }

    }

    public function getOrders()
    {        
        $query = "SELECT ot.id number_ot,ot.problem, ot.date_admission date, ot.priority priority, ot.description description, ot.type_service service, e.name enterprise, c.name component, s.name state
                  FROM ot
                  JOIN enterprise e ON ot.enterprise_id = e.id
                  JOIN component c ON ot.component_id = c.id
                  JOIN ot_state os ON ot.id = os.ot_id
                  JOIN state s ON os.state_id = s.id
                  WHERE os.id = (
                      SELECT f.id 
                      FROM ot_state f 
                      WHERE f.ot_id = ot.id AND f.date_update = (
                            SELECT MAX(j.date_update)
                            FROM ot_state j
                            WHERE j.ot_id = ot.id
                          ) 
                    ) 
        "; 
        return $this->db->query($query)->result_array(); 
    }

    /////////////////////

    public function getOrdersTest()
    {        
        $query = "SELECT ot.id number_ot, ot.date_admission date , ot.description, ot.priority priority, ot.description description, ot.type_service service, e.name enterprise, l.name location, c.name component, s.name state,r.check_adm ,r.check_technical
                         , tr.details technical_report , r.date_limit date_limit ,ev.details evaluation ,ht.details hydraulic_test,ev.state ev_state, ht.state ht_state, tr.state tr_state, s.id id_state
                  FROM ot
                  JOIN enterprise e ON ot.enterprise_id = e.id
                  JOIN component c ON ot.component_id = c.id
                  JOIN ot_state os ON ot.id = os.ot_id
                  JOIN reparation r ON ot.id=r.ot_id
                  LEFT JOIN ot_location ol ON ot.id = ol.ot_id
                  LEFT JOIN locations l ON ol.location_id = l.id
                  LEFT JOIN evaluation ev ON ot.id=ev.ot_id
                  LEFT JOIN hydraulic_test ht ON ot.id=ht.ot_id
                  LEFT JOIN technical_report tr ON ot.id= tr.ot_id
                  JOIN state s ON os.state_id = s.id
                  WHERE os.id = (
                      SELECT f.id 
                      FROM ot_state f 
                      WHERE f.ot_id = ot.id AND f.date_update = (
                            SELECT MAX(j.date_update)
                            FROM ot_state j
                            WHERE j.ot_id = ot.id
                          ) 
                    )   AND
                ol.id =  (
                    SELECT MAX(j.id)
                    FROM ot_location j
                    WHERE j.ot_id = ot.id
                ) 
        "; 
        return $this->db->query($query)->result_array(); 
    }
    /////////////////////////////

    public function getComponents(){
        return $query = $this->db->get_where('component', array('state' => 1))->result_array();
    }

    public function getEnterprises(){
        return $query = $this->db->get_where('enterprise', array('state' => 1))->result_array();
    }

    public function getLocations()
    {

        return $query=$this->db->get('locations')->result_array();
    }

    public function getTechnicals()
    {
        $this->db->select('u.id, u.full_name' );
        $this->db->from('user u'); 
        $this->db->join('user_role ur', 'ur.user_id = u.id','left');
        $this->db->where('ur.role_id', 3);
        $this->db->where('u.state', 1);
        return $query = $this->db->get()->result();
    }

    public function createOrder($data, $user_id){
        $this->db->select('*'); $this->db->from('ot'); $this->db->where('id', $data['ot_number']);
        $query = $this->db->get();
        if(sizeof($query->result()) != 0){
            return false;
        }else{
            $datos_ot = array(
                'id' => $data['ot_number'],
                'date_admission' => $data['date_admission'],
                'days_quote'=> $data['days_quotation'],
                'description' => $data['description'],
                'problem' => $data['problem'],
                'type_service' => $data['service'],
                'priority' => $data['priority'],
                'component_id' => $data['component'],
                'enterprise_id' => $data['enterprise'],
                'config' => json_encode(array(
                    'evaluation' => $data['check_evaluation'],
                    'technical_report' => $data['check_report_technical'],
                    'hydraulic_test' => $data['check_hydraulic_test'],
                )),
            );

            if($this->db->insert('ot', $datos_ot)) {
                $state = '';
                if($data['service'] == "Reparación" || $data['service'] == "Mantención"){
                    $state = 1;
                }else if($data['service'] == "Fabricación"){
                    $state = 4;
                }
                $datos_ot_state = array(
                    'ot_id' => $data['ot_number'],
                    'state_id' => $state,
                    'user_id' => $user_id,
                );
                $this->db->insert('ot_state', $datos_ot_state);
                
                if($data['location']){
                    $datos_ot_location = array(
                        'ot_id' => $data['ot_number'],
                        'location_id' => $data['location'],
                        'user_id' => $user_id,
                    );
                    $this->db->insert('ot_location', $datos_ot_location);
                }

                if($data['technical']){
                    $datos_ot_user = array(
                        'ot_id' => $data['ot_number'],
                        'state_id' => 1,
                        'user_id' => $data['technical'],
                    );
                    $this->db->insert('ot_user', $datos_ot_user);
                }

                $datos_note = array(
                    'ot_id' => $data['ot_number'],
                );
                $this->db->insert('notes', $datos_note);

                $datos_reparation = array(
                    'ot_id' => $data['ot_number'],
                    'check_adm' => 0,   
                    'check_technical' => 0, 
                    'user_interaction' => json_encode(array(
                        'user_assignment' => '',
                        'date_reparation' =>  '',
                        'user_modify' => '',
                        'date_modify' => '',
                        'user_approve' => '',
                        'date_approve' => '',
                    )), 
                );
                $this->db->insert('reparation', $datos_reparation);
                return true;
            }else{
                return false;
            }
        }
    }

    public function updateOrder($data, $user_id){

        $query = "SELECT * FROM ot WHERE (id = ? AND id != ?)";
        $result = $this->db->query($query, array($data['ot_number'], $data['ot_number_old']));

        if(sizeof($result->result()) >= 1){
            return false;
        }else{
            $datos_ot = array(
                'id' => $data['ot_number'],
                'date_admission' => $data['date_admission'],
                'days_quote'=> $data['days_quotation'],
                'description' => $data['description'],
                'problem' => $data['problem'],
                'type_service' => $data['service'],
                'priority' => $data['priority'],
                'component_id' => $data['component'],
                'enterprise_id' => $data['enterprise'],
/*                 'date_provider_number' => $data['date_provider_number'],
                'provider_number' => $data['provider_number'], */
                'config' => json_encode(array(
                    'evaluation' => $data['check_evaluation'],
                    'technical_report' => $data['check_report_technical'],
                    'hydraulic_test' => $data['check_hydraulic_test'],
                )),
            );
            $this->db->where('id', $data['ot_number_old']);
            if($this->db->update('ot', $datos_ot)){

                /* Hacer el cambio de ubicación si es necesario */
                $location = '';
                if($data['location']){
                   $location = $data['location'];
                }else{
                   $location = 1;
                } 
                if($data['location'] != $data['location_old']){
                    $datos_ot_location = array(
                        'ot_id' => $data['ot_number'],
                        'location_id' => $location,
                        'user_id' => $user_id,
                    );
                    $this->db->insert('ot_location', $datos_ot_location);
                }
                 /* Hacer el cambio de estado si es necesario */
                if($data['service'] != $data['service_old']){
                    $state_old = '';
                    $state_new = '';
                    /*Determino el estado antiguo*/
                    if($data['service_old'] == "Reparación" || $data['service_old'] == "Mantención"){
                        $state_old = 1;
                    }else if($data['service_old'] == "Fabricación"){
                        $state_old = 4;
                    }
                     /*Determino el estado nuevo*/
                    if($data['service'] == "Reparación" || $data['service'] == "Mantención"){
                        $state_new = 1;
                    }else if($data['service'] == "Fabricación"){
                        $state_new = 4;
                    }
                    /* Si los estados son distintos recien se actualiza el cambio*/
                    if($state_old != $state_new){
                        $datos_ot_state = array(
                            'ot_id' => $data['ot_number'],
                            'state_id' => $state_new,
                            'user_id' => $user_id,
                        );
                        $this->db->insert('ot_state', $datos_ot_state);
                    }
                }

                return true;
            }else{
                return false;
            }       
        }
    }

    public function createEvaluation($id_ot, $id_technical){
        $this->db->select('*'); $this->db->from('evaluation'); $this->db->where('ot_id', $id_ot);
        $query = $this->db->get();
        date_default_timezone_set("America/Santiago");
        $date_priority= null;
        if($id_technical){
           $date_priority= date('Y-m-d H:i:s');
        }
        $datos_ev = array(
            'ot_id' => $id_ot,
            'state' => 1,
            'priority' => "2",
            'user_assignment'=> $id_technical,
            'user_interaction' => json_encode(array(
                'user_create' => '',
                'date_create' =>  '',
                'user_modify' => '',
                'date_modify' => '',
                'user_approve' => '',
                'date_approve' => '',
            )),
            'date_priority'=> $date_priority,
        );

        if(sizeof($query->result()) == 0){
            $this->db->insert('evaluation', $datos_ev);
            return true; 
        }else if (sizeof($query->result()) == 1){
            $this->db->where('ot_id', $id_ot);
            $this->db->update('evaluation', $datos_ev);
            return true;  
        }else{
            return false;
        }
    }

    public function desEvaluation($id_ot){
        $datos_ev = array(
            'state'=> 0,
        );
        $this->db->where('ot_id', $id_ot);
        $this->db->update('evaluation', $datos_ev);
        return true;
    }

    public function createTechnicalReport($id_ot, $id_technical){
        $this->db->select('*'); $this->db->from('technical_report'); $this->db->where('ot_id', $id_ot);
        $query = $this->db->get();
        date_default_timezone_set("America/Santiago");
        $date_priority= null;
        if($id_technical){
           $date_priority= date('Y-m-d H:i:s');
        }
        $datos_tr = array(
            'ot_id' => $id_ot,
	    'state' => 1,
	    'details' => json_encode(array(
                'date_technical_report' => "",
                'image_header' => "",
                'details' => "",
                'notes' => "",
                'check_adm' => "",
                'check_technical' => "",
                'conclusion' => "",
                'recommendation' =>"",
            )),
            'user_assignment'=> $id_technical,
            'user_interaction' => json_encode(array(
                'user_create' => '',
                'date_create' => '',
                'user_modify' => '',
                'date_modify' => '',
                'user_approve' => '',
                'date_approve' => '',
            )),
            'date_priority'=> $date_priority,
        );
        $datos_tr_update = array(
            'state' => 1,
        );
        if(sizeof($query->result()) == 0){
            $this->db->insert('technical_report', $datos_tr);
            return true; 
        }else if (sizeof($query->result()) == 1){
            
            $this->db->where('ot_id', $id_ot);
            $this->db->update('technical_report', $datos_tr_update);
            return true;  
        }else{
            return false;
        }
    }

    public function desTechnicalReport($id_ot){
        $datos_tr = array(
            'state'=> 0,
        );
        $this->db->where('ot_id', $id_ot);
        if($this->db->update('technical_report', $datos_tr))
        return true;
    }

    public function createHydraulicTest($id_ot){
        $this->db->select('*'); $this->db->from('hydraulic_test'); $this->db->where('ot_id', $id_ot);
        $query = $this->db->get();
        $datos_ht = array(
            'state' => 1,
            'ot_id' => $id_ot,
            'user_interaction' => json_encode(array(
                'user_create' => '',
                'date_create' => '',
                'user_modify' => '',
                'date_modify' => '',
                'user_approve' => '',
                'date_approve' => '',
            )),
        );

        if(sizeof($query->result()) == 0){
            $this->db->insert('hydraulic_test', $datos_ht);
            return true; 
        }else if (sizeof($query->result()) == 1){
            $this->db->where('ot_id', $id_ot);
            $this->db->update('hydraulic_test', $datos_ht);
            return true;  
        }else{
            return false;
        }
    }

    public function createAprobation($data){
        $fecha = $data['date_admission'];
        $dias = $data['days_quotation'];
        $day_limit = $this-> dayEnd($fecha, $dias);
        $datos_ap = array(
            'ot_id' =>$data['ot_number'],
            'approve_client'=> false,
            'date_limit' => $day_limit,
        );

        return $this->db->insert('quotation', $datos_ap);
    }

    public function desHydraulicTest($id_ot){
        $datos_ht = array(
            'state'=> 0,
        );
        $this->db->where('ot_id', $id_ot);
        if($this->db->update('hydraulic_test', $datos_ht)) 
        return true;
    }

    public function changeStateOrder($data, $user_id){

        if($data['state'] == 7){
            $datos_ht = array('state'=> 0);
            $this->db->where('ot_id', $data['ot_number']);
            $this->db->update('hydraulic_test', $datos_ht); 

            $datos_tr = array('state'=> 0);
            $this->db->where('ot_id', $data['ot_number']);
            $this->db->update('technical_report', $datos_tr); 

            $datos_ev = array('state'=> 0);
            $this->db->where('ot_id', $data['ot_number']);
            $this->db->update('evaluation', $datos_ev); 

            $datos_ot = array(
                'config' => json_encode(array(
                    'evaluation' => false,
                    'technical_report' => false,
                    'hydraulic_test' => false,
                )),
            );
            $this->db->where('id', $data['ot_number']);
            $this->db->update('ot', $datos_ot);
        }
        
        $datos_ot_state = array(
            'ot_id' => $data['ot_number'],
            'state_id' => $data['state'],
            'user_id' => $user_id,
        );
        if($this->db->insert('ot_state', $datos_ot_state)) return true; else return false; 
    }

    public function changeLocationOrder($data, $user_id){

        $datos_ot_location= array(
            'ot_id' => $data['ot_number'],
            'location_id' => $data['location'],
            'user_id' => $user_id,
        );
        if($this->db->insert('ot_location', $datos_ot_location)) return true; else return false; 
    }

    public function updateApprobation($data){
        $fecha = $data['date_admission'];
        $dias = $data['days_quotation'];
        $day_limit = $this-> dayEnd($fecha, $dias);
        $datos_ap = array(
            'date_limit' => $day_limit
        );
        $this->db->where('ot_id', $data['ot_number']);
        $this->db->update('quotation', $datos_ap);
    }

    public function getHistoryStatesByOrder($id){
        $query = "SELECT ot_s.date_update date, u.full_name user, s.name state
        FROM ot_state ot_s
        JOIN user u ON ot_s.user_id = u.id
        JOIN state s ON ot_s.state_id = s.id
        WHERE ot_s.ot_id = $id"; 
        return $this->db->query($query)->result_array(); 
    }

    public function dayEnd($fecha_v, $dias_v){
        $fecha = $fecha_v;
        $dias = $dias_v;
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

