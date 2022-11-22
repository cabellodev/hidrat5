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
                $id = $_SESSION['id'];
                $sql="SELECT  c.enterprise_id 
                FROM client c 
                WHERE c.id = $id";
                $q = $this->db->query($sql)->row_array();
                $id_enterprise = $q['enterprise_id'];
 

                $sql="SELECT  O.id, O.type_service,O.date_admission, S.name state, O.type_service, C.name component
                FROM ot_state OS INNER JOIN ot O
                ON OS.ot_id = O.id 
                INNER JOIN state S ON S.id = OS.state_id
                INNER JOIN component C ON C.id = O.component_id
                WHERE O.enterprise_id = $id_enterprise AND OS.state_id = 1 AND OS.date_update= (SELECT MAX(OS2.date_update)
                                FROM ot_state OS2
                                WHERE OS2.ot_id = O.id)";
                $data1 = $this->db->query($sql)->result();
                

                $sql = "SELECT  O.id, O.type_service,O.date_admission, S.name state, O.type_service, C.name component
                FROM ot_state OS INNER JOIN ot O
                 ON OS.ot_id = O.id 
                INNER JOIN state S ON S.id = OS.state_id
                INNER JOIN component C ON C.id = O.component_id
                WHERE O.enterprise_id = $id_enterprise AND OS.state_id = 2 AND OS.date_update= (SELECT MAX(OS2.date_update)
                                FROM ot_state OS2
                                WHERE OS2.ot_id = O.id)";
                $data2 = $this->db->query($sql)->result();

                $sql = "SELECT  O.id, O.type_service,O.date_admission, S.name state, O.type_service, C.name component
                FROM ot_state OS INNER JOIN ot O
                 ON OS.ot_id = O.id 
                INNER JOIN state S ON S.id = OS.state_id
                INNER JOIN component C ON C.id = O.component_id
                WHERE O.enterprise_id = $id_enterprise AND OS.state_id = 3 AND OS.date_update= (SELECT MAX(OS2.date_update)
                                FROM ot_state OS2
                                WHERE OS2.ot_id = O.id)";
                $data3 = $this->db->query($sql)->result();

                $sql = "SELECT  O.id, O.type_service,O.date_admission, S.name state, O.type_service, C.name component
                FROM ot_state OS INNER JOIN ot O
                 ON OS.ot_id = O.id 
                INNER JOIN state S ON S.id = OS.state_id
                INNER JOIN component C ON C.id = O.component_id
                WHERE O.enterprise_id = $id_enterprise AND OS.state_id = 4 AND OS.date_update= (SELECT MAX(OS2.date_update)
                                FROM ot_state OS2
                                WHERE OS2.ot_id = O.id)";
                $data4 = $this->db->query($sql)->result();

                $sql = "SELECT  O.id, O.type_service,O.date_admission, S.name state, O.type_service, C.name component
                FROM ot_state OS INNER JOIN ot O
                 ON OS.ot_id = O.id 
                INNER JOIN state S ON S.id = OS.state_id
                INNER JOIN component C ON C.id = O.component_id
                WHERE O.enterprise_id = $id_enterprise AND OS.state_id = 5 AND OS.date_update= (SELECT MAX(OS2.date_update)
                                FROM ot_state OS2
                                WHERE OS2.ot_id = O.id)";
                $data5 = $this->db->query($sql)->result();

                $sql = "SELECT  O.id, O.type_service,O.date_admission, S.name state, O.type_service, C.name component
                FROM ot_state OS INNER JOIN ot O
                 ON OS.ot_id = O.id 
                INNER JOIN state S ON S.id = OS.state_id
                INNER JOIN component C ON C.id = O.component_id
                WHERE O.enterprise_id = $id_enterprise AND OS.state_id = 6 AND OS.date_update= (SELECT MAX(OS2.date_update)
                                FROM ot_state OS2
                                WHERE OS2.ot_id = O.id)";
                $data6 = $this->db->query($sql)->result();

                $sql = "SELECT  O.id, O.type_service,O.date_admission, S.name state, O.type_service, C.name component
                FROM ot_state OS INNER JOIN ot O
                 ON OS.ot_id = O.id 
                INNER JOIN state S ON S.id = OS.state_id
                INNER JOIN component C ON C.id = O.component_id
                WHERE O.enterprise_id = $id_enterprise AND OS.state_id = 7 AND OS.date_update= (SELECT MAX(OS2.date_update)
                                FROM ot_state OS2
                                WHERE OS2.ot_id = O.id)";
                $data7 = $this->db->query($sql)->result();


                return array("evaluation"=> $data1 , 
                             "e_quotation" => $data2, 
                             "e_aprobation" => $data3, 
                             "reparation" => $data4, 
                             "ready_retirement" => $data5,
                             "finished" => $data6,
                             "down" => $data7,
                        );
        }
}