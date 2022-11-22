<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH.'third_party/fpdf/fpdf.php';
class HydraulicTest extends CI_Controller
{
    public function getHydraulicTestByOrder($id)
    { 
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('HydraulicTestModel');
            if($res=$this->HydraulicTestModel->getHydraulicTestByOrder($id)){
                $this->response->sendJSONResponse($res); 
            }else{
                $this->response->sendJSONResponse(array('msg' => 'Esta orden no tiene configurada una prueba hidraulica.'), 400); 
            }
            }else{
                
                $this->response->sendJSONResponse(array('msg' => 'No tiene permisos suficientes.'), 400);
            }
    }


    public function get_info_ht($id)
    { 
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('HydraulicTestModel');
            if($res=$this->HydraulicTestModel->get_info_ht($id)){
                $this->response->sendJSONResponse($res); 
            }else{
                $this->response->sendJSONResponse(array('msg' => 'Esta orden no tiene configurada una prueba hidraulica.'), 400); 
            }
            }else{
                
                $this->response->sendJSONResponse(array('msg' => 'No tiene permisos suficientes.'), 400);
            }
    }


  

    public function editInfoHt($id){

        if($this->accesscontrol->checkAuth()['correct']) {
        $data = $this->input->post('data');
        $data2= $this->input->post('data2');
     
        $ok=true;
        if($ok){ 
            $this->load->model('HydraulicTestModel');
            if($this->HydraulicTestModel->editInfoHt($id,$data)){
                $pdf = $this->pdfHidraulicTest($data2,$data);
                $this->HydraulicTestModel->pdfHidraulicTest($id, $pdf );
            $this->response->sendJSONResponse( array("msg"=>"Se ha editado con éxito "));
            }else{ 
            $this->response->sendJSONResponse( array("msg" => "No se han podido editar los datos "),400); 
            }
            
        }else { $this->response->sendJSONResponse( array("msg" => "Complete todos los campos de la evaluación. "),400); }

        }else {
            $this->response->sendJSONResponse( array("msg" => "No tiene los permisos suficientes "),400);
        }
    }




    public function editPdf($id)
    {   
        $config['upload_path'] = "./assets/upload/";
        $config['allowed_types'] = '*';
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload("pdf")) {
            $data = array('upload_data' => $this->upload->data());
            $pdf = $data['upload_data']['file_name'];
            $array = explode(".", $pdf); //divide string y convierte en array 
           
            $formato =  $array[1];// selecciona el indice 1 igual a pdf 
        
            if($formato == "pdf") {
            $this->load->model('HydraulicTestModel');
                 if ( $res = $this->HydraulicTestModel->uploadPdf($id, $pdf)) {
                     $this->response->sendJSONResponse(array('msg' => "Archivo subido con éxito."));
                     } else {
                       $this->response->sendJSONResponse(array('msg' => "error"), 500);
                      }
            }else { $this->response->sendJSONResponse(array('msg' => "Cargue un formato correcto por favor"), 500); } 
        } else {
            $this->response->sendJSONResponse(array(
                "msg" => "error",
                "id" => $id, "i" => $this->upload->display_errors(),
                "c" => $config['upload_path']
            ));
        }
    }


    public function getPdf($id)
    { 

        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('HydraulicTestModel');
            if($res=$this->HydraulicTestModel->getPdf($id)){
                $this->response->sendJSONResponse($res); 
            }else{
                $this->response->sendJSONResponse(array('msg' => 'No se han podido traer los datos del archivo'), 400); 
            }
            }else{
                
                $this->response->sendJSONResponse(array('msg' => 'No tiene permisos suficientes.'), 400);
            }
    }


    public function deletePdf($id)
    {
        if ($this->accesscontrol->checkAuth()['correct']) {
            
            $data = $this->input->post('data');
            $name = $data['pdf'];
            $this->load->model('HydraulicTestModel');
            if ( $response = $this->HydraulicTestModel->deletePdf($id)) {
                unlink('./assets/upload/' . $name);
                $this->response->sendJSONResponse(array("msg" => "El archivo fue eliminado con éxito"));
            } else {
                $this->response->sendJSONResponse(array('status' => "error"), 500);
            }
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }

    public function save_config($id){

        if($this->accesscontrol->checkAuth()['correct']) {
        $data = $this->input->post('data');
        $data2 = $this->input->post('data2');
        $data3 = $this->input->post('data3');

        $ok=true;
        if($ok){ 
            $this->load->model('HydraulicTestModel');
            if($this->HydraulicTestModel->save_config($id,$data)){
                $pdf = $this->pdfHidraulicTest($data2,$data3);
                $this->HydraulicTestModel->pdfHidraulicTest($id, $pdf );
            $this->response->sendJSONResponse( array("msg"=>"Configuración guardada. "));
            }else{ 
            $this->response->sendJSONResponse( array("msg" => "No se han podido registrar los datos "),400); 
            }
            
        }else { $this->response->sendJSONResponse( array("msg" => "Complete todos los campos de la evaluación. "),400); }

        }else {
            $this->response->sendJSONResponse( array("msg" => "No tiene los permisos suficientes "),400);
        }
    }


    public function editHydraulicTest($id){

        if($this->accesscontrol->checkAuth()['correct']) {
        $data = $this->input->post('data');
        $data2= $this->input->post('data2');
        $conclusion=$data['conclusion'];
        $notes = $data['notes'];
        $technical = $data['technical'];

        

        $ok = true;

       /* if($_SESSION['rango']== 3){

                if ($conclusion == "") { $ok = false;  $err['conclusion']  = "Ingrese fecha de evaluación";  }
                if ($notes == "") { $ok = false;  $err['notes']  = "Ingrese un tecnico";  }

            }*/
  
        if($ok){ 
            $this->load->model('HydraulicTestModel');
            if($this->HydraulicTestModel->editHydraulicTest($id,$data)){

              //  $old=$data['old_pdf'];
               // $pdf = $this->fpdf_lib->pdfEvaluation($data);
                $pdf = $this->pdfHidraulicTest($data,$data2);

                $this->HydraulicTestModel->pdfHidraulicTest($id, $pdf );
            $this->response->sendJSONResponse( array("msg"=>"Se ha editado con éxito "));
            }else{ 
            $this->response->sendJSONResponse( array("msg" => "No se han podido editar los datos "),400); 
            }
            
        }else { $this->response->sendJSONResponse( array("msg" => "Complete todos los campos de la evaluación. "),400); }

        }else {
            $this->response->sendJSONResponse( array("msg" => "No tiene los permisos suficientes "),400);
        }
    }





    public function pdfHidraulicTest($data,$data2){
        
        $pdf = new PDF();
        $url="http://localhost/hidrat/";
        $pdf->AliasNbPages();
        $pdf->AddPage('P','Letter');
        $pdf->SetFont('Arial','B',14);
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
        if($_SESSION['rango' ]== 3){
            $pdf->Cell(40, 6, date('Y-m-d'), 1, 0, 'C', 1);
        }else{
            $pdf->Cell(40, 6, $data['date_ht'], 1, 0, 'C', 1);
        }
        $pdf->Cell(50, 6, $data['id'], 1, 0, 'C', 1);
        $pdf->Cell(50, 6, utf8_decode($data['technical_name']), 1, 0, 'C', 1);
        $pdf->Cell(50, 6, date('Y-m-d H:i:s'), 1, 1, 'C', 1);
        $pdf->Ln(10);

        $pdf->SetFont('Arial','B',15);
        $pdf->SetTextColor(19,66,115);
        $pdf->Cell(190,6,utf8_decode('Notas'),0,0,'C');
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetTextColor(0,0,0);
        $pdf-> MultiCell(0, 6 , utf8_decode($data['notes']) ,1 ,'J'); // 
        $pdf->Ln(10);

        $pdf->SetFont('Arial','B',15);
        $pdf->SetTextColor(19,66,115);
        $pdf->Cell(190,6,utf8_decode('Detalles técnicos'),0,0,'C');
        $pdf->Ln(10);
        $pdf->SetFont('Arial','B',9);
        $pdf->SetFillColor(232, 232, 232);
        $pdf->SetTextColor(0,0,0);
     
        $pdf->Cell(50, 6, utf8_decode('Dato'), 1, 0, 'C', 1);
        $pdf->Cell(35, 6, utf8_decode('Velocidad'), 1, 0, 'C', 1);
        $pdf->Cell(35, 6, utf8_decode('Presión'), 1, 0, 'C', 1);
        $pdf->Cell(35, 6, utf8_decode('Caudal'), 1, 0, 'C', 1);
        $pdf->Cell(35, 6, utf8_decode('Temperatura') , 1, 1, 'C', 1);
        $pdf->SetFillColor(250, 250, 250);
        $info = json_decode($data2);
        foreach ($info as $key => $value) {
            
           
            $pdf->Cell(50, 6, utf8_decode($value->dato), 1, 0, 'C', 1);
            if($data['config_speed']=="true"){ $pdf->Cell(35, 6, utf8_decode($value->speed), 1, 0, 'C', 1);}else{
                $pdf->Cell(35, 6, "-", 1, 0, 'C', 1);
            }
            if($data['config_presion']=="true"){ $pdf->Cell(35, 6, utf8_decode($value->presion), 1, 0, 'C', 1);}else{
                $pdf->Cell(35, 6, "-", 1, 0, 'C', 1);
            }
            if($data['config_caudal']=="true"){$pdf->Cell(35, 6, utf8_decode($value->caudal), 1, 0, 'C', 1);}else{
                $pdf->Cell(35, 6, "-", 1, 0, 'C', 1);
            }
            if($data['config_temperature']=="true"){
                $pdf->Cell(35, 6, utf8_decode($value->time) , 1, 1, 'C', 1);}else{
                     $pdf->Cell(35, 6, "-", 1, 1, 'C', 1);
                }
            
        }
        $pdf->Ln(10);
        

        $pdf->SetFont('Arial','B',15);
        $pdf->SetTextColor(19,66,115);
        $pdf->Cell(190,6,utf8_decode('Conclusión'),0,0,'C');
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetTextColor(0,0,0);
        $pdf-> MultiCell(0, 6 , utf8_decode($data['conclusion']) ,1 ,'J'); // 
        $pdf->Ln(10);
       
        $name = "assets/upload/hydraulicTest" . $data['id'] . ".pdf";
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
   $this->Cell(0, 5,  utf8_decode('Informe de Test hidráulico '), 0, 0, 'C');
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




    

