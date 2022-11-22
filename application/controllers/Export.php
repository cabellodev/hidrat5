<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH.'third_party/fpdf/fpdf.php';


class Export extends CI_Controller
{
    
    public function generateExport(){

        if($this->accesscontrol->checkAuth()['correct']) {
        $data = $this->input->post('data');
           if($pdf = $this->export_pdf($data)){
             $this->response->sendJSONResponse( array("msg" => $pdf));
            }else{ 
             $this->response->sendJSONResponse( array("msg" => "No se ha podido generar el reporte. "),400);
             }
        }else {
            $this->response->sendJSONResponse( array("msg" => "No tiene los permisos suficientes "),400);
        }
    }



    public function export_pdf($data){
        
        $pdf = new PDF();
        $url="http://localhost/hidrat1/";
        $pdf->AliasNbPages();
        $pdf->AddPage('P','Letter');
       
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial', 'BU', 15);

        
        $pdf->Cell(190,6,utf8_decode('Información general de OT'),0,0,'C');
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFillColor(232, 232, 232);
        $pdf->Cell(40, 6, utf8_decode('Número OT'), 1, 0, 'C', 1);
        $pdf->Cell(50, 6, utf8_decode('Fecha de admisión'), 1, 0, 'C', 1);
        $pdf->Cell(50, 6, utf8_decode('Componente'), 1, 0, 'C', 1);
        $pdf->Cell(50, 6, utf8_decode('Servicio'), 1, 1, 'C', 1);
      //date('Y-m-d H:i:s') sacar datos de fecha
        $pdf->SetFillColor(250, 250, 250);
        $pdf->Cell(40, 6, utf8_decode($data['number_ot']), 1, 0, 'C', 1);
        $pdf->Cell(50, 6, utf8_decode($data['date_admission']), 1, 0, 'C', 1);
        $pdf->Cell(50, 6, utf8_decode($data['component']), 1, 0, 'C', 1);
        $pdf->Cell(50, 6, utf8_decode($data['service']), 1, 1, 'C', 1);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFillColor(232, 232, 232);
        $pdf->Cell(40, 6, utf8_decode('Prioridad'), 1, 0, 'C', 1);
        $pdf->Cell(150, 6, utf8_decode('Cliente'), 1, 1, 'C', 1);
        $pdf->SetFillColor(250, 250, 250);
        $pdf->Cell(40, 6, utf8_decode($data['priority']), 1, 0, 'C', 1);
        $pdf->Cell(150, 6, utf8_decode($data['enterprise']), 1, 1, 'C', 1);
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
        $pdf->Cell(190,6,utf8_decode('Problema'),0,0,'C');
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetTextColor(0,0,0);
        $pdf-> MultiCell(190, 6 , utf8_decode($data['problem']) ,1 ,'J'); // 
        $pdf->Ln(10);
       
        $name = "assets/upload/export" . rand(1,100000) . ".pdf";
        $pdf->output("F", $name);
        return $name;
    }
}


class PDF extends FPDF
{

function Header()
{   

   $this->Image('http://localhost/hidrat1/assets/img/hidratec_report.jpeg',10,8,50,0); 
   $this->SetFont('Arial', 'B', 10);
   $this->SetTextColor(19,66,115);
   $this->SetX(-50);
   $this->Write(10,'Fecha: '.date('Y-m-d'));
   $this->SetDrawColor(19,66,115);
   $this->Line(10,22,200,22);
   $this->Ln(20);
  

}

function Footer()
{
   $this->SetY(-15);
   $this->SetFont('Arial','I',8);
   $this->Cell(0,10,utf8_decode('Hidratec-Sistemas Oleohidráulicos'),0,0,'C');
   $this->Cell(-15,10,utf8_decode('Página ') . $this->PageNo(),0,0,'C');
}


}

