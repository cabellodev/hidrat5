<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH.'third_party/fpdf/fpdf.php';

class TechnicalReport extends CI_Controller
{
    public function __construct(){
		parent:: __construct(); 
		$this->load->model('TechnicalReportModel');
     
	}

    public function adminTechnicalReports(){

        if ($this->accesscontrol->checkAuth()['correct']) {
            
            $rango = $_SESSION['rango'];
            if($rango == 1){
            $this->load->view('shared/headerSuperAdmin');
            $this->load->view('admin/adminTechnicalReports');
            $this->load->view('shared/footer');
            }else if($rango == 2){
            $this->load->view('shared/headerAdmin');
            $this->load->view('admin/adminTechnicalReports');
            $this->load->view('shared/footer');
            } 
        } else {
            redirect('Home/login', 'refresh');
        }
    }
    public function getTechnicalReportApprove(){
        $technicalReports= $this->TechnicalReportModel->getTechnicalReportApprove();
        $this->response->sendJSONResponse($technicalReports);
    }

    public function getTechnicalReportByOrder($id)
    { 
        if ($this->accesscontrol->checkAuth()['correct']) {
            if($report=$this->TechnicalReportModel->getTechnicalReportByOrder($id)){
                $technicals = $this->TechnicalReportModel->getTechnicals();
                $this->response->sendJSONResponse(array($report, $technicals)); 
            }else{
                $this->response->sendJSONResponse(array('msg' => 'Esta orden no tiene configurado un reporte técnico.'), 400); 
            }
        }else {
			redirect('Home/login', 'refresh');
        }
    }

    public function getImagesByTechnicalReport()
    { 
        if ($this->accesscontrol->checkAuth()['correct']) {
            $data = $this->input->post('data'); 
            if($res=$this->TechnicalReportModel->getImagesByTechnicalReport($data)){
                $this->response->sendJSONResponse($res); 
            }else{
                $msg['msg'] = "La órden de trabajo no tiene mas imagenes asociadas.";
                $this->response->sendJSONResponse($msg);
                $this->output->set_status_header(405);
            }
        }else {
            redirect('Home/login', 'refresh');
        }
    }

    public function editTechnicalReport()
    { 
        if ($this->accesscontrol->checkAuth()['correct']) {
            /* Datos de formulario*/
			$data = $this->input->post('data');
            /*Update technical report*/
            /*Success*/
            $id = $_SESSION['id'];
            date_default_timezone_set("America/Santiago");
            $date_update = date("Y-m-d G:i:s");
            if($this->TechnicalReportModel->editTechnicalReport($data, $date_update)){
                /*Verify changes in approve technical report*/
                $this->getPdfTechnicalReport();
                $msg['msg'] = "Reporte técnico actualizado con éxito.";
                $this->response->sendJSONResponse($msg);
            /*Fail */
            }else{
                $msg['msg'] = "No se pudo encontrar el recurso.";
                $this->response->sendJSONResponse($msg);
                $this->output->set_status_header(405);
            } 	
        }else {
            redirect('Home/login', 'refresh');
        }
    }

    public function getPdfTechnicalReport()
    { 
        if ($this->accesscontrol->checkAuth()['correct']) {
            $data = $this->input->post('data');
            $ot_id = $data['ot_id'];
            $report=$this->TechnicalReportModel->getTechnicalExport($ot_id);
            
            $enterprise = $report[0]['enterprise'];
            $component = $report[0]['component'];
            $data = json_decode($report[0]['data'],true);
            $data_images = json_decode($report[0]['data_images'],true);
            $data_interaction = json_decode($report[0]['data_interaction'],true);

            $details = $data['details'];
            $conclusion = $data['conclusion'];
            $recommendation = $data['recommendation'];

            $technical = $data_interaction['user_create'];
            $head_service = $data_interaction['user_approve'];
            
            
            $pdf = new PDF();
            $pdf->AddPage('PORTRAIT','LETTER');
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial', 'BU', 15);
            $pdf->Cell(0, 5,  utf8_decode('Informe Técnico Orden de Trabajo '.$ot_id), 0, 0, 'C');
            $pdf->Ln(10);         


            /* Página Antecedentes generales*/
            if($data['image_header']){
            $a = $this->correctImageOrientation('http://localhost/hidrat5/assets/upload/'.$data['image_header']);
            //$a = $this->adjustPicOrientation('http://localhost/hidrat5/assets/upload/'.$data['image_header']);
            $pdf->Image($a, 110, 70, 90); 
            }
            $pdf->SetFont('Arial', 'B', 15);
            $pdf->SetTextColor(19,66,115);
            $pdf->Cell(200, 5,  utf8_decode('Antecedentes Generales'), 0, 0, 'C');     
            $pdf->Ln(10);
    
    
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(70, 5,  utf8_decode('Cliente'), 0, 0, 'L');
            $pdf->Ln();
            $pdf->SetLineWidth(0.5);
            $pdf->SetDrawColor(19,66,115);
            $pdf->MultiCell(92.6, 1, '________________________________', 0,'L',0);
                $pdf->Ln(7);
    
                $pdf->SetFont('Arial', '', 10);
                $pdf->SetLineWidth(0.2);
                $pdf->SetFillColor(240,240,240);
                $pdf->SetTextColor(40,40,40);
                $pdf->SetDrawColor(255,255,255);
                $pdf->MultiCell(90,10,utf8_decode($enterprise),1,'C',1);
            
            $pdf->Ln(20);
            
    
            $pdf->SetTextColor(19,66,115);
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(70, 5,  utf8_decode('Servicio'), 0, 0, 'L');
            $pdf->Ln();
            $pdf->SetLineWidth(0.5);
            $pdf->SetDrawColor(19,66,115);
            $pdf->MultiCell(92.6, 1, '________________________________', 0,'L',0);
                $pdf->Ln(7);
    
                $pdf->SetFont('Arial', '', 10);
                $pdf->SetLineWidth(0.2);
                $pdf->SetFillColor(240,240,240);
                $pdf->SetTextColor(40,40,40);
                $pdf->SetDrawColor(255,255,255);
                $pdf->Cell(30,10, utf8_decode('Jefe de Servicio'),1,0,'C',1);
                $pdf->MultiCell(60,10, utf8_decode($head_service),1,'C',1);
                $pdf->Cell(30,10, utf8_decode('Técnico Evaluador'),1,0,'C',1);
                $pdf->MultiCell(60,10, utf8_decode($technical),1,'C',1);
           
            $pdf->Ln(20);
    
            $pdf->SetTextColor(19,66,115);
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(70, 5,  utf8_decode('Componente'), 0, 0, 'L');
            $pdf->Ln();
            $pdf->SetLineWidth(0.5);
            $pdf->SetDrawColor(19,66,115);
            $pdf->MultiCell(92.6, 1, '________________________________', 0,'L',0);
                $pdf->Ln(7);
                $pdf->SetFont('Arial', '', 10);
                $pdf->SetLineWidth(0.2);
                $pdf->SetFillColor(240,240,240);
                $pdf->SetTextColor(40,40,40);
                $pdf->SetDrawColor(255,255,255);
                $pdf->MultiCell(90,10, utf8_decode($component),1,'C',1);
            
            $pdf->Ln(20);
    
            $pdf->SetTextColor(19,66,115);
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(70, 5,  utf8_decode('Detalles'), 0, 0, 'L');
            $pdf->Ln();
            $pdf->SetLineWidth(0.5);
            $pdf->SetDrawColor(19,66,115);
            $pdf->MultiCell(92.6, 1, '________________________________', 0,'L',0);
                $pdf->Ln(7);
    
                $pdf->SetFont('Arial', '', 10);
                $pdf->SetLineWidth(0.2);
                $pdf->SetFillColor(240,240,240);
                $pdf->SetTextColor(40,40,40);
                $pdf->SetDrawColor(255,255,255);
                $pdf->MultiCell(90,10, utf8_decode($details),1,'C',1);


            /* Detalle informe técnico */

            if($data_images){
                $cont = 1;
                $pdf->SetDrawColor(19,66,115);
                for($i=1; $i<= count($data_images); $i++){
                    list($x1, $y1) = getimagesize('http://localhost/hidrat5/assets/upload/'.$data_images[$i]['image']);
                    $x = 0;
                    $y = 0;
                    $x_image = 0;
                    if($x1 > $y1) {
                        $x = 60;
                        $y = 0;
                        $x_image = 20;
                    } else {
                        $x = 0;
                        $y = 55;
                        $x_image = 30;
                    }
                    if($cont == 1){
                        $pdf->AddPage('PORTRAIT','LETTER');
                        $pdf->SetFont('Arial', 'B', 15);
                        $pdf->SetTextColor(19,66,115);
                        $pdf->Cell(200, 5,  utf8_decode('Detalle Informe Técnico'), 0, 0, 'C');     
                        $pdf->Ln(20);
        
                       
    
                        $pdf->MultiCell(80, 59, $pdf->Image('http://localhost/hidrat5/assets/upload/'.$data_images[$i]['image'],$x_image,52,$x, $y) , 1, 'C');
        
                        $pdf->SetFont('Arial', 'B', 12);
                        $pdf->SetTextColor(0,0,0);
                        $pdf->SetY(50);
                        $pdf->SetX(90);
            
                        $charactersName =  utf8_decode(strlen($data_images[$i]['name']));
                        $total = ceil($charactersName/50); 
                        $pdf->MultiCell(120,10,  utf8_decode($data_images[$i]['name']), 1, 'L');
    
                        if($total >= 2){
                            $y_description = 62;
                        }else{
                            $y_description = 60;
                        }
            
                        $pdf->SetFont('Arial', '', 10);
                        $pdf->SetY($y_description);
                        $pdf->SetX(90);
                        $pdf->MultiCell(120,10,  utf8_decode($data_images[$i]['description']), 0, 'L');
                        $pdf->SetY($y_description);
                        $pdf->SetX(90); 
                        $pdf->MultiCell(120, 49, '' , 1, 'J'); 
                        $pdf->Ln(5);
                    }else if($cont == 2){
                        $pdf->MultiCell(80, 58, $pdf->Image('http://localhost/hidrat5/assets/upload/'.$data_images[$i]['image'],$x_image,115,$x, $y) , 1, 'C');
                        
                        $pdf->SetFont('Arial', 'B', 12);
                        $pdf->SetTextColor(0,0,0);
                        $pdf->SetY(114);
                        $pdf->SetX(90);
                        $pdf->MultiCell(120,10,  utf8_decode($data_images[$i]['name']) , 1, 'L');
                
                
                        $pdf->SetFont('Arial', '', 10);
                        $pdf->SetY(124);
                        $pdf->SetX(90);
                        $pdf->MultiCell(0,6,  utf8_decode($data_images[$i]['description']) , 0, 'L');
                        $pdf->SetY(114);
                        $pdf->SetX(90);
                        $pdf->MultiCell(120, 58, '' , 1, 'J');
                        $pdf->Ln(5); 
                    }else if($cont == 3){
                        $pdf->MultiCell(80, 58, $pdf->Image('http://localhost/hidrat5/assets/upload/'.$data_images[$i]['image'],$x_image,181,$x, $y) , 1, 'C');
                        
                        $pdf->SetFont('Arial', 'B', 12);
                        $pdf->SetTextColor(0,0,0);
                        $pdf->SetY(177);
                        $pdf->SetX(90);
                        $pdf->MultiCell(120,10,  utf8_decode($data_images[$i]['name']) , 1, 'L');
                
                
                        $pdf->SetFont('Arial', '', 10);
                        $pdf->SetY(187);
                        $pdf->SetX(90);
                        $pdf->MultiCell(0,6,  utf8_decode($data_images[$i]['description']) , 0, 'L');
                        $pdf->SetY(177);
                        $pdf->SetX(90);
                        $pdf->MultiCell(120, 58, '' , 1, 'J');
                        $cont = 0;
                    }
                    $cont++;
                }
            }else{
                $pdf->AddPage('PORTRAIT','LETTER');
                $pdf->SetFont('Arial', 'B', 15);
                $pdf->SetTextColor(19,66,115);
                $pdf->Cell(200, 5,  utf8_decode('Detalle Informe Técnico'), 0, 0, 'C');     
                $pdf->Ln(20);
            }

            /* Página Conlusion y recomendacion */
            $pdf->AddPage('PORTRAIT','LETTER');
            $pdf->SetDrawColor(19,66,115);
            $pdf->SetFont('Arial', 'B', 15);
            $pdf->SetTextColor(19,66,115);
            $pdf->Cell(200, 5,  utf8_decode('Conclusión y Recomendación'), 0, 0, 'C');     
            $pdf->Ln(10);
    
    
            $pdf->SetTextColor(19,66,115);
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(50,6,utf8_decode('Conclusión'),0,0,'J');
            $pdf->Ln(10);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial', '', 10);
            $pdf-> MultiCell(0, 6 , utf8_decode($conclusion) ,1 ,'J'); // 
            $pdf->Ln(10);
    
            $pdf->SetTextColor(19,66,115);
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(50,6,utf8_decode('Recomendación'),0,0,'J');
            $pdf->Ln(10);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial', '', 10);
            $pdf-> MultiCell(0, 6 , utf8_decode($recommendation) ,1 ,'J'); // 
            $pdf->Ln(10);
    




            $name = "assets/upload/technicalReport/technical_report_" . $ot_id . ".pdf";
            $pdf->output("F", $name);
           /*  $pdf = $this->fpdf_lib->pdfTechnicalReport($ot_id, $report); */
            $msg['msg'] = "No se pudo encontrar el recurso.";
            $this->response->sendJSONResponse($msg);
        }else {
            redirect('Home/login', 'refresh');
        }
    }

    public function correctImageOrientation($filename) {
        if (function_exists('exif_read_data')) {
          $exif = exif_read_data($filename);
          if($exif && isset($exif['Orientation'])) {
            $orientation = $exif['Orientation'];
            if($orientation != 1){
              $img = imagecreatefromjpeg($filename);
              $deg = 0;
              switch ($orientation) {
                case 3:
                  $deg = 180;
                  break;
                case 6:
                  $deg = 270;
                  break;
                case 8:
                  $deg = 90;
                  break;
              }
              if ($deg) {
                $img = imagerotate($img, $deg, 0);        
              }
              // then rewrite the rotated image back to the disk as $filename 
              return $img;


            } // if there is some rotation necessary
          } // if have the exif orientation info
        } // if function exists      
      }
}


class PDF extends FPDF
{
    var $widths;
    var $aligns;
    
    function Header()
    {   
        /*Header*/
        $this->Image('http://localhost/hidrat5/assets/upload/technicalReport/tr_img_cabecera.png',10,8,50,0,'png'); 
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(19,66,115);
        $this->SetX(-50);
        $this->Write(10,'Fecha: '.date('Y-m-d'));
        $this->SetDrawColor(19,66,115);
        $this->Line(10,22,200,22);
        $this->Ln(20);
        $this->SetTextColor(0,0,0);
        $this->SetFont('Arial', 'BU', 15);
    }
    
    function Footer()
    {
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(19,66,115);
        $this->SetY(-28);
        $this->SetX(-28);
        $this->Write(5, utf8_decode('Página '.$this->PageNo()));
    }
    
    
    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths=$w;
    }
    
    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns=$a;
    }
    
    function Row($data)
    {
        //Calculate the height of the row
        $nb=0;
        for($i=0;$i<count($data);$i++)
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h=5*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            $this->Rect($x,$y,$w,$h);
            //Print the text
            $this->MultiCell($w,5,$data[$i],0,$a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        //Go to the next line
        $this->Ln($h);
    }
    
    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }
    
    function NbLines($w,$txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r",'',$txt);
        $nb=strlen($s);
        if($nb>0 and $s[$nb-1]=="\n")
            $nb--;
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        while($i<$nb)
        {
            $c=$s[$i];
            if($c=="\n")
            {
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep=$i;
            $l+=$cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i=$sep+1;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }

}

