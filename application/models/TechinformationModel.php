<?php
class TechinformationModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    

    public function getTechnical(){

        $this->db->select('user.full_name,user.id');
        $this->db->from('user');
        $this->db->join('user_role', 'user.id = user_role.user_id');
        $this->db->where('role_id', 3  );
        $query = $this->db->get(); 
        return $query->result();
    }
    

    public function getAssistent(){

        $this->db->select('user.full_name,user.id');
        $this->db->from('user');
        $this->db->join('user_role', 'user.id = user_role.user_id');
        $this->db->where('role_id', 4  );
        $query = $this->db->get(); 
        return $query->result();
    }



    public function getOrdersWorked($id_technical)
    {        
        $query = "SELECT ot.id ot_number , r.check_adm check_admin_r ,r.check_technical check_technical_r , ev.details details_ev, ht.details details_ht, tr.details details_tr, 
                   tr.user_assignment technical_tr,ev.user_assignment technical_ev,ht.user_assignment technical_ht,r.user_assignment technical_r,s.name state_name , ot.date_admission,r.date_reparation
                  FROM ot
                  JOIN enterprise e ON ot.enterprise_id = e.id
                  JOIN component c ON ot.component_id = c.id
                  JOIN ot_state os ON ot.id = os.ot_id
                  JOIN reparation r ON ot.id=r.ot_id
                  LEFT JOIN evaluation ev ON ot.id=ev.ot_id
                  LEFT JOIN hydraulic_test ht ON ot.id=ht.ot_id
                  LEFT JOIN technical_report tr ON ot.id= tr.ot_id
                  JOIN state s ON os.state_id = s.id
                  WHERE (ev.user_assignment=$id_technical or ht.user_assignment =$id_technical or tr.user_assignment=$id_technical or r.user_assignment=$id_technical ) and  os.id = (
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

    public function getOrdersWorkedAT($data)
    {        
        $periodo = $data['periodo'];
        $user = $data['user'];
        $year = $data['year'];
        $month = $data['month'];
    
        if($periodo == '2'){
            $query = "SELECT 
                        ot.id ot_number, ot.date_admission,  s.name state_name,
                        se.id, se.check_tm , se.check_at, se.date_assigment, se.date_end, se.hours, subs_ev.name sub_ev
            
                        FROM ot
                                JOIN enterprise e ON ot.enterprise_id = e.id
                                JOIN component c ON ot.component_id = c.id
                                JOIN ot_state os ON ot.id = os.ot_id
                                JOIN state s ON os.state_id = s.id
                                LEFT JOIN subtask_evaluation se ON ot.id = se.ot_id
                                LEFT JOIN subtask subs_ev ON se.subtask_id = subs_ev.id                           
                        WHERE (
                               (se.user_id = $user AND YEAR(se.date_end)= $year) 
                              ) and os.id = (
                                            SELECT f.id 
                                            FROM ot_state f 
                                            WHERE f.ot_id = ot.id AND f.date_update = (
                                                    SELECT MAX(j.date_update)
                                                    FROM ot_state j
                                                    WHERE j.ot_id = ot.id
                                                ) 
                    )";
            $subs_ev =  $this->db->query($query)->result_array();

            $query = "SELECT 
                        ot.id ot_number, ot.date_admission,  s.name state_name,
                        sr.id, sr.check_tm , sr.check_at, sr.date_assigment, sr.date_end, sr.hours, subs_sr.name sub_sr
            
                        FROM ot
                                JOIN enterprise e ON ot.enterprise_id = e.id
                                JOIN component c ON ot.component_id = c.id
                                JOIN ot_state os ON ot.id = os.ot_id
                                JOIN state s ON os.state_id = s.id                         
                                LEFT JOIN subtask_reparation sr ON ot.id = sr.ot_id
                                LEFT JOIN subtask subs_sr ON sr.subtask_id = subs_sr.id                             
                        WHERE (
                               (sr.user_id = $user AND YEAR(sr.date_end)= $year) and (sr.check_tm =1)
                              ) AND (sr.check_tm =1) and os.id = (
                                            SELECT f.id 
                                            FROM ot_state f 
                                            WHERE f.ot_id = ot.id AND f.date_update = (
                                                    SELECT MAX(j.date_update)
                                                    FROM ot_state j
                                                    WHERE j.ot_id = ot.id
                                                ) 
                    )";
            $subs_sr =  $this->db->query($query)->result_array();
            return array("subs_ev" => $subs_ev, "subs_sr" => $subs_sr);

        }else if ($periodo == '1'){
            $query = "SELECT 
                        ot.id ot_number, ot.date_admission,  s.name state_name,
                        se.id, se.check_tm , se.check_at, se.date_assigment, se.date_end, se.hours, subs_ev.name sub_ev
            
                        FROM ot
                                JOIN enterprise e ON ot.enterprise_id = e.id
                                JOIN component c ON ot.component_id = c.id
                                JOIN ot_state os ON ot.id = os.ot_id
                                JOIN state s ON os.state_id = s.id
                                LEFT JOIN subtask_evaluation se ON ot.id = se.ot_id
                                LEFT JOIN subtask subs_ev ON se.subtask_id = subs_ev.id
                                                            
                        WHERE (
                               (se.user_id = $user AND YEAR(se.date_end)= $year AND  MONTH(se.date_end) = $month) 
                              )  AND (se.check_tm =1) and os.id = (
                                            SELECT f.id 
                                            FROM ot_state f 
                                            WHERE f.ot_id = ot.id AND f.date_update = (
                                                    SELECT MAX(j.date_update)
                                                    FROM ot_state j
                                                    WHERE j.ot_id = ot.id
                                                ) 
                    )";
             $subs_ev =  $this->db->query($query)->result_array();

             $query = "SELECT 
             ot.id ot_number, ot.date_admission,  s.name state_name,
             sr.id, sr.check_tm , sr.check_at, sr.date_assigment, sr.date_end, sr.hours, subs_sr.name sub_sr
 
             FROM ot
                     JOIN enterprise e ON ot.enterprise_id = e.id
                     JOIN component c ON ot.component_id = c.id
                     JOIN ot_state os ON ot.id = os.ot_id
                     JOIN state s ON os.state_id = s.id
                     LEFT JOIN subtask_reparation sr ON ot.id = sr.ot_id
                     LEFT JOIN subtask subs_sr ON sr.subtask_id = subs_sr.id                             
             WHERE (
                    (sr.user_id = $user AND YEAR(sr.date_end)= $year AND  MONTH(sr.date_end) = $month)
                   )  AND (sr.check_tm =1) AND os.id = (
                                 SELECT f.id 
                                 FROM ot_state f 
                                 WHERE f.ot_id = ot.id AND f.date_update = (
                                         SELECT MAX(j.date_update)
                                         FROM ot_state j
                                         WHERE j.ot_id = ot.id
                                     ) 
                )";
              $subs_sr =  $this->db->query($query)->result_array();
              return array("subs_ev" => $subs_ev, "subs_sr" => $subs_sr);
        }
 
    }

    public function selectTech($technical){
        $this->db->select('user.full_name');
        $this->db->from('user');
        $this->db->where('id', $technical);
        $query = $this->db->get(); 
        return $query->result();

    }


    public function getInfoRep($ot_id)
    {        
        $query = "SELECT  r.time_end  , r.hours ,u.full_name ,r.date_reparation   
                  FROM ot
                  JOIN component c ON ot.component_id = c.id
                  LEFT JOIN reparation r ON ot.id = r.ot_id
                  JOIN user u ON u.id = r.user_assignment
                  WHERE r.ot_id = $ot_id
        "; 
        return $this->db->query($query)->result_array(); 
    }



    public function getInfoEvaluation($ot_id)
    {        
        $query = "SELECT ev.details  , ev.time_end  , ev.hours, ev.export ,u.full_name  
                  FROM ot
                  JOIN component c ON ot.component_id = c.id
                  LEFT JOIN evaluation ev ON ot.id=ev.ot_id
                  JOIN user u ON u.id = ev.user_assignment
                  WHERE ev.ot_id = $ot_id
        "; 
        return $this->db->query($query)->result_array(); 
    }

    
    public function getInfoTr($ot_id)
    {        
        $query = "SELECT tr.details , tr.time_end , tr.hours,  u.full_name
                  FROM ot
                  JOIN component c ON ot.component_id = c.id
                  LEFT JOIN technical_report tr ON ot.id=tr.ot_id
                  JOIN user u ON u.id = tr.user_assignment
                  WHERE tr.ot_id = $ot_id 
        "; 
        return $this->db->query($query)->result_array(); 
    }

    public function getInfoHt($ot_id)
    {        
        $query = "SELECT ht.details , ht.time_end ,ht.hours, u.full_name , ht.export
                  FROM ot
                  JOIN component c ON ot.component_id = c.id
                  LEFT JOIN hydraulic_test ht ON ot.id=ht.ot_id
                  JOIN user u ON u.id = ht.user_assignment
                  WHERE ht.ot_id = $ot_id 
        "; 
        return $this->db->query($query)->result_array(); 
    }




    
}

