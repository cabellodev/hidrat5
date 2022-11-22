<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH.'third_party/fpdf/fpdf.php';

class Evaluation extends CI_Controller
{
    public function getEvaluationByOrder($id)
    { 
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('EvaluationModel');
            if($res=$this->EvaluationModel->getEvaluationByOrder($id)){
                $this->response->sendJSONResponse($res); 
            }else{
                $this->response->sendJSONResponse(array('msg' => 'Esta orden no tiene configurada una evaluación.'), 400); 
            }
            }else{
                
                $this->response->sendJSONResponse(array('msg' => 'No tiene permisos suficientes.'), 400);
            }
    }


    public function editEvaluation($id){

        if($this->accesscontrol->checkAuth()['correct']) {
        $data = $this->input->post('data');
        $date_evaluation = $data['date_evaluation'];
        $description = $data['description'];
        $notes = $data['notes'];
        $technical = $data['technical'];
        $priority= $data['priority'];
       
        $ok=true;

        if($_SESSION['rango']== 2 || $_SESSION['rango']== 1 ){
        if ($priority == "") { $ok = false;  $err['priority']  = "Ingrese prioridad";  }}
   /*   
        if ($date_evaluation== "") { $ok = false;  $err['date_evaluation']  = "Ingrese fecha de evaluación";  }
        if ($description == "") { $ok = false;  $err['description']  = "Ingrese description.";  }
        if ($notes == "") { $ok = false;  $err['notes']  = "Ingrese un notas.";  }
        if ($technical == "") { $ok = false;  $err['technical']  = "Ingrese un tecnico";  }

        */
  
        if($ok){ 
            $this->load->model('EvaluationModel');
            if($this->EvaluationModel->editEvaluation($id,$data)){

            // $pdf = $this->fpdf_lib->pdfEvaluation($data);
             $pdf = $this->pdfEvaluation($data);
             $this->EvaluationModel->pdfEvaluation($id, $pdf);
            $this->response->sendJSONResponse( array("msg"=>"Se ha editado con éxito "));
           // $this->response->sendJSONResponse(array('msg' => "Cotización editada.", "resp" => $resp, "pdf" => $pdf));
            }else{ 
            $this->response->sendJSONResponse( array("msg" => "No se han podido editar los datos "),400); 
            }
            
        }else { $this->response->sendJSONResponse( array("msg" => "Determine nivel de prioridad de la evaluación. ", "err"=> $err),400); }

        }else {
            $this->response->sendJSONResponse( array("msg" => "No tiene los permisos suficientes "),400);
        }
    }





    public function pdfEvaluation($data){
        $pdf = new PDF();
        $url="http://localhost/hidrat/";
        $pdf->AliasNbPages();
        $pdf->AddPage('P','Letter');
        $pdf->SetFont('Arial','B',15);
        $pdf->SetTextColor(19,66,115);
        $pdf->Cell(190,6,utf8_decode('Antecedentes generales'),0,0,'C');
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFillColor(232, 232, 232);
        $pdf->Cell(40, 6, 'Fecha ingreso', 1, 0, 'C', 1);
        $pdf->Cell(50, 6, 'OT', 1, 0, 'C', 1);
        $pdf->Cell(50, 6, utf8_decode('Técnico'), 1, 0, 'C', 1);
        $pdf->Cell(50, 6, utf8_decode('Fecha emisión'), 1, 1, 'C', 1);
      //date('Y-m-d H:i:s') sacar datos de fecha
        $pdf->SetFillColor(250, 250, 250);
        $pdf->Cell(40, 6, utf8_decode($data['date_evaluation']), 1, 0, 'C', 1);
        $pdf->Cell(50, 6, utf8_decode($data['id']), 1, 0, 'C', 1);
        $pdf->Cell(50, 6, utf8_decode($data['name_technical']), 1, 0, 'C', 1);
        $pdf->Cell(50, 6, date('Y-m-d H:i:s'), 1, 1, 'C', 1);
        $pdf->Ln(10);
      
        $pdf->SetFont('Arial','B',15);
        $pdf->SetTextColor(19,66,115);
        $pdf->Cell(190,6,utf8_decode('Descripción'),0,0,'C');
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetTextColor(0,0,0);
        $pdf-> MultiCell(190, 6 , utf8_decode($data['description']) ,1 ,'J'); // 
        $pdf->Ln(10);

        $pdf->SetFont('Arial','B',15);
        $pdf->SetTextColor(19,66,115);
        $pdf->Cell(190,6,utf8_decode('Notas'),0,0,'C');
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetTextColor(0,0,0);
        $pdf-> MultiCell(190, 6 , utf8_decode($data['notes']) ,1 ,'J'); // 
        $pdf->Ln(10);
       
        
     
        $name = "assets/upload/evaluation" . $data['id']. ".pdf";
        $pdf->output("F", $name);
        return $name;
    }


}



   class PDF extends FPDF
     {

	function Header()
	{   

        $this->Image('http://localhost/hidrat/assets/img/hidratec_report.jpeg',10,8,50,0); 
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(19,66,115);
        $this->SetX(-50);
        $this->Write(10,'Fecha: '.date('Y-m-d'));
        $this->SetDrawColor(19,66,115);
        $this->Line(10,22,200,22);
        $this->Ln(20);
        $this->SetTextColor(0,0,0);
        $this->SetFont('Arial', 'BU', 15);
        $this->Cell(0, 5,  utf8_decode('Informe de Evaluación'), 0, 0, 'C');
        $this->Ln(10);
	}
    
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,utf8_decode('Hidratec-Sistemas Oleohidráulicos'),0,0,'C');
        $this->Cell(-15,10,utf8_decode('Página ') . $this->PageNo(),0,0,'C');
    }


     }
