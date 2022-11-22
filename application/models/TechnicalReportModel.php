<?php

class TechnicalReportModel extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function getTechnicalReportByOrder($id){
        $query= "SELECT tr.details data, tr.details_images data_images, u.id user, tr.user_interaction data_interaction
        FROM technical_report tr
        LEFT JOIN user u ON u.id = tr.user_assignment
        WHERE tr.ot_id = ? AND tr.state = ? ";
        return $this->db->query($query, array($id,true))->result_array(); 
    } 

    public function getImagesByTechnicalReport($data){

        $id_ot = $data['ot_id'];
        $images_seleccionadas = $data['images'];
        $var = "";
        $cont = 1;
        if($images_seleccionadas){
            foreach ($images_seleccionadas as &$valor) {
                if($cont == count($images_seleccionadas)){
                    $var = $var." i.id != ".$valor;
                }else{
                    $var = $var." i.id != ".$valor." AND";
                }
                $cont++;
            }
            $query= "SELECT * FROM images i WHERE $var AND i.ot_id = $id_ot";
            if($res = $this->db->query($query, array($id_ot))->result()) return $res; else return false;
        }else{
            $query= "SELECT * FROM images i WHERE i.ot_id = $id_ot";
            if($res = $this->db->query($query, array($id_ot))->result()) return $res; else return false;
        }

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

    public function getTechnicalExport($id){
        $query= "SELECT tr.details data, tr.details_images data_images, u.id user, tr.user_interaction data_interaction, e.name enterprise, c.name component
        FROM technical_report tr
        LEFT JOIN user u ON u.id = tr.user_assignment
        LEFT JOIN ot ON ot.id = tr.ot_id
        LEFT JOIN enterprise e ON e.id = ot.enterprise_id
        LEFT JOIN component c ON c.id = ot.component_id
        WHERE tr.ot_id = ? AND tr.state = ? ";
        return $this->db->query($query, array($id,true))->result_array(); 
    } 

    public function editTechnicalReport($data, $date_update){
        $user = $_SESSION['full_name'];
        date_default_timezone_set("America/Santiago");
        $date = date("Y-m-d G:i:s");
        $date_priority=  null; 
        $datos_tr = '';
        $user_create = '';    
        $date_create = '';
        $imagenes = $data['details_images'];
        
        if($data['profile'] == 'technicalMaster'){
            if($data['check_technical'] == 'true'){
                $user_create = $user;
                $date_create = $date;
                $this->setTimeEnd($data['ot_id']);
            }else{
                $user_create = '';
                $date_create = '';
            }

            if($data['details_images']) $details_images = json_encode($data['details_images']);
            else $details_images = null;

            $datos_tr = array(
                'details' => json_encode(array(
                    'date_technical_report' => $date_create,
                    'image_header' => $data['image_header'],
                    'details' => $data['details'],
                    'notes' => $data['notes'],
                    'check_adm' => '',
                    'check_technical' => $data['check_technical'],
                    'conclusion' => $data['conclusion'],
                    'recommendation' => $data['recommendation'],
                )),
                'time_end' => $date_create,
                'details_images' =>  strval($details_images),
                'user_interaction' => json_encode(array(
                    'user_create' => $user_create,
                    'date_create' => $date_create,
                    'user_modify' => $user,
                    'date_modify' => $date,
                    'user_approve' => '',
                    'date_approve' => '',
                )),
            );

        }else if($data['profile'] == 'admin'){
            $technical = null;
            $user_approve = ''; 
            $date_approve = '';
              
            if($data['technical']){
                $technical = $data['technical'];
                $date_priority= $date;
            }

            /*Verify changes in approve technical report*/
            if($data['check_adm'] == 'true' AND $data['check_adm_old'] =='false'){
                $date_approve = $date;
                $user_approve = $user;
            }else if($data['check_adm'] == 'true' AND $data['check_adm_old'] =='true'){
                $date_approve = $data['date_approve'];
                $user_approve = $data['user_approve'];
            }else {
                $date_approve = '';
                $user_approve = '';
            } 

            /*Verify if create technical report*/
            if($data['check_technical'] == 'true' AND $data['technical']){
                $user_create = $data['user_create'];
                $date_create = $data['date_create'];
            }else{
                $user_create = '';
                $date_create = '';
            }
            $imagenes = $data['details_images'];

            if($data['details_images']) $details_images = json_encode($data['details_images']);
            else $details_images = null;

            $datos_tr = array(
                'user_assignment' => $technical,
                'details' => json_encode(array(
                    'date_technical_report' => $data['date_technical_report'],
                    'image_header' => $data['image_header'],
                    'details' => $data['details'],
                    'notes' => $data['notes'],
                    'check_adm' => $data['check_adm'],
                    'check_technical' => $data['check_technical'],
                    'conclusion' => $data['conclusion'],
                    'recommendation' => $data['recommendation'],
                )),
                'details_images' => strval($details_images),
                'user_interaction' => json_encode(array(
                    'user_create' => $user_create,
                    'date_create' => $date_create,
                    'user_modify' => $user,
                    'date_modify' => $date,
                    'user_approve' => $user_approve,
                    'date_approve' => $date_approve,
                )),
                'date_priority'=>$date_priority,
            );                   
        }
        $this->db->where('ot_id', $data['ot_id']);
        if($this->db->update('technical_report', $datos_tr)) return true; else return false;
    }

    public function getTechnicalReportApprove(){
        $query = "SELECT ot.id number_ot, ot.date_admission date, ot.type_service service, e.name enterprise, c.name component, s.name state, tr.details, tr.user_interaction
        FROM ot
        JOIN enterprise e ON ot.enterprise_id = e.id
        JOIN component c ON ot.component_id = c.id
        JOIN ot_state os ON ot.id = os.ot_id
        JOIN technical_report tr ON ot.id = tr.ot_id
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


    public function setTimeEnd($ot_id){
        date_default_timezone_set("America/Santiago");
        $date_end = date("Y-m-d G:i:s");
        $date1 = new DateTime($date_end);
        $year1 = $date1->format('Y');
        $month1 = $date1->format('m');
        $day1 = $date1->format('d');
           
 
        $query= "SELECT tr.time_init, tr.hours
        FROM technical_report tr
        WHERE tr.ot_id = ?";
        $technicalReport = $this->db->query($query, array($ot_id))->result_array(); 

        $hoursData = $technicalReport[0]['hours'];

        $diasferiados = [ '' ];
        $date_init = $technicalReport[0]['time_init'];
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
        if($this->db->update('technical_report', $datos)) return true; else return false;
    }
}