<?php

class ExternalModel extends CI_Model {

    public function generateMensualKpi(){

        $year = date('Y');
        $month = date('m');
        $day_last = date("d", mktime(0,0,0, $month+1, 0, $year));
            
        $date_act =  date('Y-m-d');
        $date_last = date('Y-m-d', mktime(0,0,0, $month, $day_last, $year));

        $datos_record = array(
            'year' => '1',
            'month' => '1',
            'kpi_quotation' => '1',
            'kpi_production' => '1',
            'ot_quotation' => '0',
            'ot_production' => '0',
        );
        $this->db->insert('record', $datos_record);
       /*  if($date_act == $date_last){ */
          /*   $a = date('m');
            $queryKpiQuotation = "SELECT  AVG(5 * (DATEDIFF( ot.date_quotation,ot.date_admission) DIV 7) + MID('0123455401234434012332340122123401101234000123450', 7 * WEEKDAY(ot.date_admission) + WEEKDAY(ot.date_quotation) + 1, 1)) as kpi_quotation
                    FROM ot
                    WHERE  ot.date_quotation IS NOT NULL and ot.date_admission  IS NOT NULL and MONTH(ot.date_quotation) = $a
                    ";

            $value_quotation = $this->db->query($queryKpiQuotation)->row_array();

            $queryOTKpiQuotation = "SELECT ot.id
                    FROM ot
                    WHERE  ot.date_quotation IS NOT NULL and ot.date_admission  IS NOT NULL and MONTH(ot.date_quotation) = $a
                    ";
            $otKpiQuotation = $this->db->query($queryOTKpiQuotation)->result_array();


            $queryKpiProduction = "SELECT  AVG(5 * (DATEDIFF(ot.date_cellar, ot.date_reparation) DIV 7) + MID('0123455401234434012332340122123401101234000123450', 7 * WEEKDAY(ot.date_reparation) + WEEKDAY(ot.date_cellar) + 1, 1)) as kpi_production
            FROM ot
            WHERE  ot.date_cellar IS NOT NULL AND ot.date_reparation IS NOT NULL AND MONTH(ot.date_cellar) = $a
            ";
            $value_production = $this->db->query($queryKpiProduction)->row_array();

            $queryOtKpiProduction = "SELECT ot.id
            FROM ot
            WHERE  ot.date_cellar IS NOT NULL AND ot.date_reparation IS NOT NULL AND MONTH(ot.date_cellar) = $a
            ";
            $otKpiProduction = $this->db->query($queryOtKpiProduction)->result_array(); 

            $kpi_quotation = 0;
            $kpi_production = 0;

            if((int)$value_quotation["kpi_quotation"]){
                $kpi_quotation = (int)$value_quotation["kpi_quotation"];
            } 


            if((int)$value_production["kpi_production"]){
                $kpi_production = (int)$value_production["kpi_production"];
            } 


            $datos_record = array(
                'year' => $year,
                'month' => $a,
                'kpi_quotation' => $kpi_quotation,
                'kpi_production' => $kpi_production,
                'ot_kpi_quotation' => json_encode($otKpiQuotation),
                'ot_kpi_production' => json_encode($otKpiProduction),
            );
            $this->db->insert('record', $datos_record); */
       /*  }  */
    }
}