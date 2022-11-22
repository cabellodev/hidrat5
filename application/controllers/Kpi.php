<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH.'third_party/fpdf/fpdf.php';


class Kpi extends CI_Controller
{
    public function menuKpi()
    { 
        if ($this->accesscontrol->checkAuth()['correct']) {
            $user =$_SESSION['rango'];
            if($user == 1 ){
            $this->load->view('shared/headerSuperAdmin');
            $this->load->view('admin/menu_kpi');
            $this->load->view('shared/footer');
            }else if($user == 2 ){
                $this->load->view('shared/headerAdmin');
                $this->load->view('admin/menu_kpi');
                $this->load->view('shared/footer');
            }
        } else {
            redirect('Home/login', 'refresh');
        }
    }


    public function kpiQuotation()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $user =$_SESSION['rango'];
            if($user == 1 ){
            $this->load->view('shared/headerSuperAdmin');
            $this->load->view('admin/kpiQuotation');
            $this->load->view('shared/footer');
            }else if($user == 2 ){
                $this->load->view('shared/headerAdmin');
                $this->load->view('admin/kpiQuotation');
                $this->load->view('shared/footer');}
                
        } else {
            redirect('Home/login', 'refresh');
        }



    }
//$this->load->view('admin/kpiProduction');
    public function kpiProduction()
    { 
        if ($this->accesscontrol->checkAuth()['correct']) {

            $user =$_SESSION['rango'];
            if($user == 1 ){
            $this->load->view('shared/headerSuperAdmin');
            $this->load->view('admin/kpiProduction');
            $this->load->view('shared/footer');
            }else if($user == 2 ){
                $this->load->view('shared/headerAdmin');
                $this->load->view('admin/kpiProduction');
                $this->load->view('shared/footer');}
                
            
        } else {
            redirect('Home/login', 'refresh');
        }

    }

    public function periodFilterQuotation()
    { 
        if ($this->accesscontrol->checkAuth()['correct']) {
            $data = $this->input->post('data');
            $this->load->model('KpiModel');
            if($res=$this->KpiModel->kpiQuotation($data)){
                $this->response->sendJSONResponse($res);
            }else{
                $this->response->sendJSONResponse(array('err'=>"No se ha encontrado la información."), 400);
            }
        } else {
            redirect('Home/login', 'refresh');
        }

    }

    public function periodFilterProduction()
    { 
        if ($this->accesscontrol->checkAuth()['correct']) {
            $data = $this->input->post('data');
            $this->load->model('KpiModel');
            if($res=$this->KpiModel->kpiProduction($data)){
                $this->response->sendJSONResponse($res);
            }else{
                $this->response->sendJSONResponse(array('err'=>"No se ha encontrado la información."), 400);
            }
        } else {
            redirect('Home/login', 'refresh');
        }

    }

    public function getYears()
    {
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('kpiModel');
            $datos = $this->kpiModel->getYears();
            $this->response->sendJSONResponse($datos);
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }



    public function getOrders()
    { 

        $data = $this->input->post('data');
        $this->load->model('KpiModel');
		$orders = $this->KpiModel->getOrdersQuotation($data);
        $this->response->sendJSONResponse($orders);
    }

    public function generateReport(){

        if($this->accesscontrol->checkAuth()['correct']) {
        $data = $this->input->post('data');
        $observations=$data['observations'];
        $ok =true;
        
        if ($observations == '') { 
              $ok =false;
        }
       
        if($ok){ 
        
                if($pdf = $this->report_kpi_quotation($data)){

                $this->response->sendJSONResponse( array("msg" => $pdf));
              
                }else{ 
                    $this->response->sendJSONResponse( array("msg" => "No se ha podido generar el reporte. "),400);
                }
           
            
        }else { $this->response->sendJSONResponse( array("msg" => "Complete los campos para generar reporte. "),400); }

        }else {
            $this->response->sendJSONResponse( array("msg" => "No tiene los permisos suficientes "),400);
        }
    }

    public function convertImage() { 

        $data = $this->input->post('send');
        $dataURI= $data['base64'];
        $img = explode(',',$dataURI,2)[1];
        $pic = 'data://text/plain;base64,'. $img;
        $this->response->sendJSONResponse( array("msg" => $pic));
        
    }
    

    public function clean(){

        $data = $this->input->post('data');
        $pdf = $data['clean'];
        unlink($pdf);
    }

    public function test ($pic){
        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->Image($pic, 10,30,0,0,'png');
        $pdf->Output();
       
    }


    public function report_kpi_quotation ($data){
        
        $pdf = new PDF();
        $url="http://localhost/hidrat/";
        $pdf->AliasNbPages();
        $pdf->AddPage('P','Letter');
       
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial', 'BU', 15);

        if($data['kpi'] == 1 && $data['periodo']==2){
            $pdf->Cell(0, 5,  utf8_decode('Informe de indicadores de cotización (mensual) '), 0, 0, 'C');}
        if($data['kpi'] == 2 && $data['periodo']==2){
           $pdf->Cell(0, 5,  utf8_decode('Informe de indicadores de producción (mensual) '), 0, 0, 'C');}
        if($data['kpi'] == 1 && $data['periodo']==1){
           $pdf->Cell(0, 5,  utf8_decode('Informe de indicadores de cotización (anual) '), 0, 0, 'C');}
        if($data['kpi'] == 2 && $data['periodo']==1){
           $pdf->Cell(0, 5,  utf8_decode('Informe de indicadores de producción (anual) '), 0, 0, 'C');}

        $pdf->Image($data['base64'], 65,40,0,0,'png');
        $pdf->Ln(100);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFillColor(232, 232, 232);
        $pdf->Cell(40, 6, 'Año', 1, 0, 'C', 1);
        if($data['periodo']==2){
        $pdf->Cell(50, 6, 'Mes', 1, 0, 'C', 1);}
        $pdf->Cell(50, 6, utf8_decode('N°de OTs'), 1, 0, 'C', 1);
        $pdf->Cell(50, 6, utf8_decode('Kpi mensual'), 1, 1, 'C', 1);
      //date('Y-m-d H:i:s') sacar datos de fecha
        
        $pdf->Cell(40, 6, $data['year'], 1, 0, 'C', 1);
        if($data['periodo']==2){
        $pdf->Cell(50, 6, $data['month'], 1, 0, 'C', 1);}
    
        $pdf->Cell(50, 6, $data['counter'], 1, 0, 'C', 1);
        $pdf->Cell(50, 6, $data['avg'], 1, 1, 'C', 1);
        $pdf->Ln(10);


        $pdf->SetFont('Arial','B',15);
        $pdf->SetTextColor(19,66,115);
        $pdf->Cell(190,6,utf8_decode('Observaciones'),0,0,'C');
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetTextColor(0,0,0);
        $pdf-> MultiCell(0, 6 , utf8_decode($data['observations']) ,1 ,'J'); // 
        $pdf->Ln(10);

       
        $pdf->SetFont('Arial','B',15);
        $pdf->SetTextColor(19,66,115);
        $pdf->Cell(190,6,utf8_decode('Sugerencias'),0,0,'C');
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetTextColor(0,0,0);
        $pdf-> MultiCell(0, 6 , utf8_decode($data['sugerence']) ,1 ,'J'); // 
        $pdf->Ln(10);


       
       
        $name = "assets/upload/reportKpiQuotation" . rand(1,100000) . ".pdf";
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
  

}

function Footer()
{
   $this->SetY(-15);
   $this->SetFont('Arial','I',8);
   $this->Cell(0,10,utf8_decode('Hidratec-Sistemas Oleohidráulicos'),0,0,'C');
   $this->Cell(-15,10,utf8_decode('Página ') . $this->PageNo(),0,0,'C');
}


}

