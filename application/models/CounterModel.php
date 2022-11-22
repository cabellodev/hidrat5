<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CounterModel extends CI_Model
{

        public function __construct()
        {
                parent::__construct();
        }

        public function getDataCounter()
        {       
                $sql="SELECT  O.id, O.type_service,O.date_admission,e.name ,O.description,r.date_limit
                FROM ot_state OS 
                INNER JOIN ot O ON OS.ot_id = O.id 
                JOIN enterprise e ON e.id = O.enterprise_id
                INNER JOIN state S ON S.id = OS.state_id
                INNER JOIN reparation r ON O.id = r.ot_id
                WHERE OS.state_id = 1 AND OS.date_update= (SELECT MAX(OS2.date_update)
                                FROM ot_state OS2
                                WHERE OS2.ot_id = O.id)";
                $data0 = $this->db->query($sql)->result();
                

                $sql = "SELECT  O.id, O.type_service,O.date_admission,e.name ,O.description, r.date_limit
                FROM ot_state OS INNER JOIN ot O
                 ON OS.ot_id = O.id 
                 JOIN enterprise e ON e.id = O.enterprise_id
                INNER JOIN state S ON S.id = OS.state_id
                INNER JOIN reparation r ON O.id = r.ot_id
                WHERE OS.state_id = 2 AND OS.date_update= (SELECT MAX(OS2.date_update)
                                FROM ot_state OS2
                                WHERE OS2.ot_id = O.id)";
                $data1 = $this->db->query($sql)->result();

                $sql = "SELECT  O.id, O.type_service,O.date_admission ,e.name ,O.description,r.date_limit
                FROM ot_state OS 
                INNER JOIN ot O ON OS.ot_id = O.id 
                 JOIN enterprise e ON e.id = O.enterprise_id
                INNER JOIN state S ON S.id = OS.state_id
                INNER JOIN reparation r ON O.id = r.ot_id
                WHERE OS.state_id = 3 AND OS.date_update= (SELECT MAX(OS2.date_update)
                                FROM ot_state OS2
                                WHERE OS2.ot_id = O.id)";
                $data2 = $this->db->query($sql)->result();

                $sql = "SELECT  O.id, O.type_service,O.date_admission, e.name ,O.description, r.date_limit
                FROM ot_state OS INNER JOIN ot O
                 ON OS.ot_id = O.id 
                 JOIN enterprise e ON e.id = O.enterprise_id
                INNER JOIN state S ON S.id = OS.state_id
                INNER JOIN reparation r ON O.id = r.ot_id
                WHERE OS.state_id = 4 AND OS.date_update= (SELECT MAX(OS2.date_update)
                                FROM ot_state OS2
                                WHERE OS2.ot_id = O.id)";
                $data3 = $this->db->query($sql)->result();

                $sql = "SELECT  O.id, O.type_service,O.date_admission,e.name ,O.description, r.date_limit 
                FROM ot_state OS INNER JOIN ot O
               
                 ON OS.ot_id = O.id 
                 JOIN enterprise e ON e.id = O.enterprise_id
                INNER JOIN state S ON S.id = OS.state_id
                INNER JOIN reparation r ON O.id = r.ot_id
                WHERE OS.state_id = 6 AND OS.date_update= (SELECT MAX(OS2.date_update)
                                FROM ot_state OS2
                                WHERE OS2.ot_id = O.id)";
                $data4 = $this->db->query($sql)->result();

                $sql = "SELECT  O.id, O.type_service,O.date_admission ,e.name ,O.description, r.date_limit  
                FROM ot_state OS INNER JOIN ot O
               
                 ON OS.ot_id = O.id 
                 JOIN enterprise e ON e.id = O.enterprise_id
                INNER JOIN state S ON S.id = OS.state_id
                INNER JOIN reparation r ON O.id = r.ot_id
                WHERE OS.state_id = 7 AND OS.date_update= (SELECT MAX(OS2.date_update)
                                FROM ot_state OS2
                                WHERE OS2.ot_id = O.id)";
                $data5 = $this->db->query($sql)->result();

                $sql = "SELECT  O.id, O.type_service,O.date_admission ,e.name ,O.description,r.date_limit  
                FROM ot_state OS INNER JOIN ot O
            
                 ON OS.ot_id = O.id 
                 JOIN enterprise e ON e.id = O.enterprise_id
                INNER JOIN state S ON S.id = OS.state_id
                INNER JOIN reparation r ON O.id = r.ot_id
                WHERE OS.state_id = 5 AND OS.date_update= (SELECT MAX(OS2.date_update)
                                FROM ot_state OS2
                                WHERE OS2.ot_id = O.id)";
                $data6 = $this->db->query($sql)->result();



                return array("evaluation"=> $data0 , "e_quotation" => $data1, "e_aprobation" => $data2, "reparation" => $data3, "finished" => $data4,
                "down" => $data5 , "retired"=> $data6);
        }
}