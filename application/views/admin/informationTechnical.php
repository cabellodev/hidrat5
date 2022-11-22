<div id="content-wrapper">
  <div class="container-fluid mb-5">

    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Seguimiento Técnico / Consultas</li>
    </ol>

    <div class="accordion" id="accordionExample">
      <div class="card mb-3">
        <div class="card-header" id="headingOne">
          <h2 class="mb-0">
            <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              INSTRUCCIONES
            </button>
          </h2>
        </div>

        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
          <div class="card-body">
           En esta sección podrá visualizar toda la información relacionada al trabajo de cada técnico dentro de los procesos de la empresa. Estas consultas se pueden realizar 
           a nivel mensual y anual.
          </div>
        </div>
      </div>
    </div>

    <div class="card mb-3">
      <div class="card-header">
        <i class="fas fa-table"></i>
        Lista de órdenes trabajadas <span id="orderby"></span>
        <button class="btn btn-success float-right" type='button' data-toggle="modal" data-target="#addComponent" id="btn_search"> Consultar técnico </button>
      </div>
      <div class="card-body">

      <div class="row mb-2" id ="general_info">
              
              <div class="col-md-4 mb-3">
                <label for="actividad">Nombre</label>
                 <div class="input-group" id='frm_dato'>
                   <input type="text" class="form-control" maxlength="10" name="dato" id="g_technical" disabled>
                   <div class="invalid-feedback"></div>
                </div>
             </div>
             <div class="col-md-4 mb-3">
                <label for="actividad">Mes</label>
                 <div class="input-group" id='frm_speed'>
                   <input type="text" class="form-control" maxlength="10" name="speed" id="g_month" disabled>
                   <div class="invalid-feedback"></div>
                </div>
             </div>
             <div class="col-md-4 mb-3">
                <label for="actividad">Año</label>
                 <div class="input-group" id='frm_presion'>
                   <input type="text" class="form-control"maxlength="10" name="presion" id="g_year" disabled>
                   <div class="invalid-feedback"></div>
                </div>
             </div>
             
          </div>



        <div id='div_at' class="table-responsive" style="display: none">
          <table class="table table-bordered" id="table-orders-worked_substacks" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Ot</th>
                <th>Ingreso OT</th>
                <th>Estado</th>
                <th>Sub Evaluación</th>
                <th>Sub Reparación</th>
              </tr>
            </thead>
          </table>
        </div>


        <div id='div_tm' class="table-responsive" >
          <table class="table table-bordered" id="table-orders-worked" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Ot</th>
                <th>Ingreso OT</th>
                <th>Estado</th>
                <th>Evaluación</th>
                <th>Informe técnico</th>
                <th>Test hidráulico</th>
                <th>Reparación</th>
              </tr>
            </thead>
          </table>
        </div>

      </div>
    </div>
  </div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="search_technical" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titulo">Búsqueda de información técnica</h5>
                    <button type="button" class="close" onclick="close_modal()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form>
                      <div class="form-group" >
                          <label>Período</label>
                          <select class="form-select form-control" id="periodo" name="range" >
                          <option value=""></option>
                              <option value="1">Mensual</option>
                              <option value="2">Anual</option>
                          </select>
                          <div class="invalid-feedback"></div>
                      </div>
                     
                      <div class="form-group" id="frm_year">
                          <label>Año</label>
                          <select class="form-select form-control" id="year" name="range" >
                          
                              <option value="2020">2020</option>
                              <option value="2021">2021</option>
                              <option value="2022">2022</option>
                          </select>
                          <div class="invalid-feedback"></div>
                      </div>
                      <div class="form-group" id="frm_month">
                          <label>Mes</label>
                          <select class="form-select form-control" id="month" name="range" >
                       
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
                      <div class="form-group" >
                          <label>Tipo de técnico</label>
                          <select class="form-select form-control" id="typeTech" name="range" >
                          <option></option>
                             <option value="1">Técnico master</option>
                              <option value="2">Ayudante técnico</option>
                          </select>
                          <div class="invalid-feedback"></div>
                      </div>
                      <div class="form-group" id="frm_name">
                          <label>Nombre</label>
                          <select class="form-select form-control" id="nameTech" name="nameTech" >
                              <option></option>
                          </select>
                          <div class="invalid-feedback"></div>
                      </div>
                    <div class="form-group float-right">
                        <button onclick="close_modal()" type="button" class="btn btn-secondary btn-danger">Cerrar</button>
                        <button id="btn_ok" type="button" class="btn btn-primary btn-success">Consultar</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="details_process" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titulo_modal_report"></h5>
                    <button type="button" class="close" onclick="close_modal_details()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form>
                      <div class="form-group" >
                          <label>Técnico encargado</label>
                          <input type="text" class="form-control" id="technical_master" name="technical_master" >
                          <div class="invalid-feedback"></div>
                      </div>

                      <div class="form-group" >
                          <label>Fecha de comienzo </label>
                          <input type="text" class="form-control" id="date_begin" name="date_begin" >
                          <div class="invalid-feedback"></div>
                      </div>
                      <div class="form-group" >
                          <label> Fecha de término </label>
                          <input type="text" class="form-control" id="date_end" name="date_end" >
                          <div class="invalid-feedback"></div>
                      </div>
                      <div class="form-group" >
                          <label> Tiempo utilizado</label>
                          <input type="text" class="form-control" id="time_used" name="date_end" >
                          <div class="invalid-feedback"></div>
                      </div>
                    <!--  <div class="form-group" >
                          <label> Visualizar informe </label>
                          <input type="text" class="form-control" id="report" name="date_end" >
                          <div class="invalid-feedback"></div>
                      </div>-->
                      <div class="form-group float-right">
                        <button onclick="close_modal_details()" type="button" class="btn btn-secondary btn-danger">Cerrar</button>
                        
                    </div>
                    
                </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="details_process_subs" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div  class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titulo_modal_report_subs"></h5>
                    <button type="button" class="close" onclick="close_modal_details_sub()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <div id='div_tm' class="table-responsive" >
                    <table class="table table-bordered" id="table-details-sub" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Subtarea</th>
                          <th>Fecha de asignación</th>
                          <th>Fecha de termino</th>
                          <th>Horas gastadas</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo base_url(); ?>assets/js_admin/informationTechnical.js"></script>
