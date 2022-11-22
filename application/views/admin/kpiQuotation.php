<div id="content-wrapper">
  <div class="container-fluid mb-5">

    <ol class="breadcrumb">
      <li class="breadcrumb-item active" id="header-title">Reportes KPI cotización</li>
    </ol>
    
    
    <div class="card mb-3">
      <div class="card-header">
        <i class="fas fa-table"></i>
        Consulta de información
      </div>
      <div class="card-body">
              <div class="row">
              <div class="col-md-2 mb-3" id="frm_priority">
                        <label for="actividad">Periodos</label>
                        <select class="custom-select d-block w-100" id="periodo" name="priority" required="">
                            <option></option>
                            <option value="1">ANUAL</option>
                            <option value="2">MENSUAL</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div> 
                   
              </div>  
              
               
               <div class="row justify-content-center " id="graphic-content"><!-- ghrapic-->
                    <div class="col-md-6 mb-3 ;" id="graphic-bar">
                        <div id="gaugeChart" style="width:350px ;height:300px"></div>
                    </div>
                </div>
                <br>
                
                <div class="row " id="alert"><!-- ghrapic-->
                    <div class="col-md-12  mb-3 " >
                        <div class="alert alert-info" role="alert">
                            No hay utilidades registradas en los periódos consultados.
                       </div>
                    </div>
              </div>
              <div class ="conteiner title">
              <div class ="row justify-content-left " >
                  <h4> <i class="fa fa-th-large" style="font-size: 20px"></i><span>&nbsp; Resultado de la consulta mensual <span></h4> 
                
             </div>
             <br>
              <div class="row justify-content-left " >
                   <div class="col-md-2 mb-3" >
                   <label for="actividad">Año</label>
                   <input type="text" style="background:white"class="form-control" id="year_info" name="name" placeholder="Ingrese nombre" disabled>
                  </div>  
                  <div class="col-md-2 mb-3" >
                   <label for="actividad">Mes</label>
                   <input type="text" style="background:white" class="form-control" id="month_info" name="name" placeholder="Ingrese nombre" disabled>
                  </div>  
                  <div class="col-md-3 mb-3" >
                   <label for="actividad">Cantidad de OT trabajadas </label>
                   <input type="text"  style="background:white" class="form-control" id="ot_info" name="name" placeholder="Ingrese nombre" disabled>
                  </div>  
                  <div class="col-md-3 mb-3" >
                   <label for="actividad">Promedio de cotización mensual</label>
                   <input type="text"   style="background:white" class="form-control" id="avg_info" name="name" placeholder="Ingrese nombre"disabled>
                  </div>  
              </div> 
              <br>
                 <div class="row justify-content-left" >
                 <div class="col-md-8 mb-3" >
                   <div class="table-responsive">
                      <table class="table table-bordered" id="table-kpi-quotation" width="100%" cellspacing="0">
                       <thead>
                            <tr>
                            <th>Número OT</th>
                             
                        </tr>
                  </thead>
               </table>
             </div>
             </div>
            </div>

              <br>
              <div class ="row justify-content-left "  >
                  <h4> <i class="fa fa-th-large" style="font-size: 20px"></i><span>&nbsp; Observaciones:<span></h4> 
             </div> 
             <br>
             <div class ="row justify-content-left "  >
             <div class="col-md-9 mb-3" >
                      <label for="actividad">Bloc de observaciones </label>
                            <textarea type="text" class="form-control" rows="2" name="description" id="observation" aria-describedby="inputGroupPrepend3"></textarea>
               </div>
             </div> 
             <br>
             <div class ="row justify-content-left "  >
                  <h4> <i class="fa fa-th-large" style="font-size: 20px"></i><span>&nbsp; Sugerencias:<span></h4> 
             </div> 
             <br>
             <div class ="row justify-content-left"  >
             <div class="col-md-9 mb-3" >
                      <label for="actividad">Bloc de sugerencias </label>
                            <textarea type="text" class="form-control" rows="2" name="description" id="sugerence" aria-describedby="inputGroupPrepend3"></textarea>
               </div>
             </div>
             <div style="margin-right: 40px; margin-bottom: 40px;">
                <button style="float: right" class="btn btn-success" type='button' id="pdf_report"> Generar reporte</button>
             </div>
             </div>

             <!-- Content information by year -->

             <div class ="conteiner title2">
              <div class ="row justify-content-left " >
                  <h4> <i class="fa fa-th-large" style="font-size: 20px"></i><span>&nbsp; Resultado de la consulta anual <span></h4> 
                
             </div>
             <br>
              <div class="row justify-content-left " >
                   <div class="col-md-2 mb-3" >
                   <label for="actividad">Año</label>
                   <input type="text" style="background:white"class="form-control" id="year_info_2" name="name" placeholder="Ingrese nombre" disabled>
                  </div>  
    
                  <div class="col-md-3 mb-3" >
                   <label for="actividad">Cantidad de OT trabajadas </label>
                   <input type="text"  style="background:white" class="form-control" id="ot_info_2" name="name" placeholder="Ingrese nombre" disabled>
                  </div>  
                  <div class="col-md-3 mb-3" >
                   <label for="actividad">Promedio de cotización anual</label>
                   <input type="text"   style="background:white" class="form-control" id="avg_info_2" name="name" placeholder="Ingrese nombre"disabled>
                  </div>  
              </div> 
              <br>
              <div class ="row justify-content-left "  >
                  <h4> <i class="fa fa-th-large" style="font-size: 20px"></i><span>&nbsp; Observaciones:<span></h4> 
             </div> 
             <br>
             <div class ="row justify-content-left "  >
             <div class="col-md-9 mb-3" >
                      <label for="actividad">Bloc de observaciones </label>
                            <textarea type="text" class="form-control" rows="2" name="description" id="observation2" aria-describedby="inputGroupPrepend3"></textarea>
               </div>
             </div> 
             <br>
             <div class ="row justify-content-left "  >
                  <h4> <i class="fa fa-th-large" style="font-size: 20px"></i><span>&nbsp; Sugerencias:<span></h4> 
             </div> 
             <br>
             <div class ="row justify-content-left"  >
             <div class="col-md-9 mb-3" >
                      <label for="actividad">Bloc de sugerencias </label>
                            <textarea type="text" class="form-control" rows="2" name="description" id="sugerence2" aria-describedby="inputGroupPrepend3"></textarea>
               </div>
             </div>
             <div style="margin-right: 40px; margin-bottom: 40px;">
                <button style="float: right" class="btn btn-success" type='button' id="pdf_report2"> Generar reporte</button>
             </div>
             </div>
      </div>
    </div>
    <div class="row mb-3"></div>
  </div>
</div>



<div class="modal fade" data-backdrop="static" data-keyboard="false" id="search_month" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo">Ingreso de período</h5>
                <button type="button" class="close" onclick="close_modal_1()" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <form>
                 <div class="form-group" id="frm_range">

                      <label for="actividad">Mes</label>
                        <select class="custom-select d-block w-100" id="month" name="priority" required="">
                            <option></option>
                            <option value="1">Enero</option>
                            <option value="2">Febrero</option>
                            <option value="3">Marzo</option>
                            <option value="4">Abril</option>
                            <option value="5">Mayo</option>
                            <option value="6">Junio</option>   
                            <option value="7">Julio</option>
                            <option value="8">Agosto</option>
                            <option value="9">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                             
                        </select>
                      <div class="invalid-feedback"></div>
                  </div>
                 
                  <div class="form-group" id="frm_range">
                  <label for="actividad">Año </label>
                        <select class="custom-select d-block w-100 year"  name="year" id= "year"  required="">
                            <option></option>
                            
                        </select>
                      <div class="invalid-feedback"></div>
                  </div>
                 
                  <div class="form-group float-right">
                      <button onclick="close_modal_1()" type="button" class="btn btn-secondary ">Cerrar</button>
                      <button id="btn_month" type="button" class="btn  btn-primary">Consultar</button>
                  </div>
              </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" data-backdrop="static" data-keyboard="false" id="search_year" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo">Ingreso de período </h5>
                <button type="button" class="close" onclick="close_modal_2()" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <form>
                  <div class="form-group" id="frm_range">
                  <label for="actividad">Año </label>
                        <select class="custom-select d-block w-100 year"  name="year" id= "year1" required="">
                            <option></option>
                            
                        </select>
                      <div class="invalid-feedback"></div>
                  </div>
                 
                  <div class="form-group float-right">
                      <button onclick="close_modal_2()" type="button" class="btn btn-secondary ">Cerrar</button>
                      <button id="btn_year" type="button" class="btn btn-primary">Consultar</button>
                  </div>
              </form>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js_admin/kpiQuotation.js"></script>