<?php
defined('BASEPATH') or exit('No direct script access allowed');

class NotificationLateModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


   public function get_orders_late ($user){

       // orders evaluation by user 

        date_default_timezone_set("America/Santiago");
        $a = date("Y-m-d");
        $query1 = "SELECT ot.date_admission ,ot.description,u.full_name technical,ev.details,ev.priority, q.date_limit, ot.id number_ot, ot.days_quote dias_cotizacion, ot.type_service service,
         5 * (DATEDIFF( '$a' , ot.date_admission) DIV 7) + MID('0123455401234434012332340122123401101234000123450', 7 * WEEKDAY(ot.date_admission) + WEEKDAY('$a') + 1, 1) as days_passed 
         FROM ot 
         JOIN quotation q ON ot.id = q.ot_id 
         JOIN evaluation ev ON ot.id = ev.ot_id 
         JOIN user u ON ev.user_assignment = u.id 
         WHERE q.approve_client = 0 AND ev.details is not null AND ev.user_assignment = $user
         ORDER BY ot.id DESC
            "; 
        $evaluations= $this->db->query($query1)->result_array();

       // orders reparation by user
        $query2 = "SELECT r.date_reparation,ot.description, r.date_limit, ot.id number_ot, ot.days_reparation dias_rep ,r.date_assignment date_admission,
        5 * (DATEDIFF( '$a' , r.date_assignment) DIV 7) + MID('0123455401234434012332340122123401101234000123450', 7 * WEEKDAY(r.date_assignment) + WEEKDAY('$a') + 1, 1) as days_passed
        FROM ot
        JOIN reparation r ON ot.id = r.ot_id
        JOIN user u ON r.user_assignment = u.id
        WHERE r.check_adm = 0 and r.check_technical= 0 AND r.user_assignment = $user AND r.date_assignment is not null
        ORDER BY ot.id DESC 
        "; 
        $reparations =$this->db->query($query2)->result_array();


        $query3 = "SELECT ht.details,ot.days_reparation dias_rep,ht.ot_id
        FROM ot
        JOIN hydraulic_test ht ON ot.id = ht.ot_id
        JOIN reparation r ON ot.id = r.ot_id
        JOIN user u ON ht.user_assignment = u.id
        WHERE ht.user_assignment = $user AND ht.details is not null AND ot.days_reparation is not null";
        $tests =$this->db->query($query3)->result_array();

        $hydraulic_test = array();

        foreach ($tests as $test) {
          
        
            $order = array( 
                'number_ot'=> json_decode($test['details'])->ot,
                'date_admission'=> json_decode($test['details'])->date_ht,
                'days_term'=> (int)$test['dias_rep'],
                'date_current'=> date('Y-m-d') ,
                'date_limit'=> $this->dayEnd(json_decode($test['details'])->date_ht,(int)$test['dias_rep']),
                'check_technical'=> json_decode($test['details'])->approve_technical,
                'check_admin'=> json_decode($test['details'])->approve_admin,

            );
          
          
            array_push($hydraulic_test, $order);
       }
       // var_dump(json_decode($hydraulic_test[0]['details'])->ot);
        

        return array( "evaluations" => $evaluations , "reparations"=>$reparations ,"hydraulic_test"=>$hydraulic_test);
       // orders tec
   }



   public function dayEnd($date_admission,$days_reparation){
    $fecha = $date_admission;
    $dias = $days_reparation;
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