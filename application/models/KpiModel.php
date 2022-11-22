<?php
class KpiModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function kpiQuotation ($data) { 
       
       if( $data['period'] == 2) { // month by year 
             
        $this->db->select('month, kpi_quotation, ot_quotation');
        $this->db->from('record');
        $this->db->where('year', $data['year'] );
        $this->db->where('month', $data['month'] );
        $query = $this->db->get(); 
        return $query->result();

       }else {// by year 

        $this->db->select('month, kpi_quotation, ot_quotation');
        $this->db->from('record');
        $this->db->where('year', $data['year']);
        $query = $this->db->get(); 
        $kpi = $query->row_array();
        if($kpi['kpi_quotation']){
            return $query->result();
        }else { 
            return false;
        }

       }
  

    }


    public function getYears() { 
       
         $this->db->select('year');
         $this->db->from('record');
         $this->db->group_by("year");
         $query = $this->db->get(); 
         return $query->result();
     }


     public function kpiProduction($data) { 
       
        if( $data['period'] == 2) { // month by year 
              
         $this->db->select(' month, kpi_production, ot_production');
         $this->db->from('record');
         $this->db->where('year', $data['year'] );
         $this->db->where('month', $data['month'] );
         $query = $this->db->get(); 
         return $query->result();
 
        }else {// by year 
 
            $this->db->select(' month, kpi_production, ot_production');
         $this->db->from('record');
         $this->db->where('year', $data['year']);
         $query = $this->db->get(); 
         $kpi = $query->row_array();
         if($kpi['kpi_production']){
             return $query->result();
         }else { 
             return false;
         }
 
        }
   
 
     }


     public function getOrdersQuotation($data) { 

        if($data['period']==2){

        $month = $data['month'];
        $year = $data['year'];
        $query1 = "SELECT  *
                   FROM ot
                   WHERE  ot.date_quotation IS NOT NULL and ot.date_admission  IS NOT NULL and MONTH(ot.date_quotation) = $month and YEAR(ot.date_quotation)=$year
                   ";

        $value = $this->db->query($query1)->result();
        return $value ;

       }else{

        $year = $data['year'];
        $query1 = "SELECT  *
                   FROM ot
                   WHERE  ot.date_quotation IS NOT NULL and ot.date_admission  IS NOT NULL  and YEAR(ot.date_quotation)=$year
                   ";

        $value = $this->db->query($query1)->result();
        return $value ;


       }
    }
   
 
}