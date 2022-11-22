<input type="hidden" class="form-control" id="ot_number" name="ot_number" value='<?= $id ?>' >
<div id="content-wrapper">
  <div class="container-fluid mb-5" id="adminColors">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Prueba hidráulica</li>
            <li class="breadcrumb-item active">OT NÚMERO <?php echo $id; ?></li>
        </ol>
        <div class="card">
          <div class="card-header" >
              <button class="btn btn-link" data-toggle="collapse" data-target="#c1" aria-expanded="true" aria-controls="technicalReportGeneral">
                  <i class="fas fa-table"></i>
                  Información 
              </button>   
          </div>
          <div class="card-body collapse show" id= "c1">
            <input type="hidden" class="form-control" id="speed_c" name="id" >
            <input type="hidden" class="form-control" id="caudal_c" name="id" >
            <input type="hidden" class="form-control" id="presion_c" name="id" >
            <input type="hidden" class="form-control" id="temperature_c" name="id" >
            <input type="hidden" class="form-control" id="technical_aux" name="technical_aux" >
        

            <input type="hidden" class="form-control" id="user_create" name="id" >
            <input type="hidden" class="form-control" id="date_create" name="id" >
            <input type="hidden" class="form-control" id="user_modify" name="id" >
            <input type="hidden" class="form-control" id="date_modify" name="id" >
            <input type="hidden" class="form-control" id="user_approve" name="id" >
            <input type="hidden" class="form-control" id="date_approve" name="id" >
            <input type="hidden" class="form-control" id="technical_name_ht" name="id" >

          
          
            <div class="row mb-2 "> 
              <div class="form-check">
                  <input class="form-check-input"  type="hidden" value="" id="approve_admin_ht" disabled>
                    <label class="form-check-label"  for="approve_admin_ht">
                  </label>
              </div>
              <div class="col-md-2 mb-3 ">
                    <div class="form-check">
                      <input class="form-check-input"  type="checkbox" value="" id="approve_technical_ht" disabled>
                      <label class="form-check-label"  for="approve_technical_ht">
                      Aprobado por técnico master
                      </label>
                    </div>
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-md-8 mb-3">
                <label for="actividad">Componente</label>
                  <div class="input-group">
                    <textarea type="text" class="form-control" rows="2" style="background:white" name="notes_ht" id="notes_ht" placeholder="" aria-describedby="inputGroupPrepend3" disabled></textarea>
                      <div class="invalid-feedback descripcion" style="display: none;  color:red">
                              Ingrese una descripción porfavor.
                      </div>
                  </div>
              </div>  
            </div>

            <div class="row mb-2">
              <div class="col-md-12 mb-3">
                <label for="actividad">Conclusiones</label>
                  <div class="input-group">
                    <textarea type="text" class="form-control" rows="2"style="background:white" name="conclusion_ht" id="conclusion_ht" placeholder="" aria-describedby="inputGroupPrepend3" disabled></textarea>
                      <div class="invalid-feedback descripcion" style="display: none;  color:red">
                              Ingrese una conclusión porfavor.
                      </div>
                  </div>
              </div> 
            </div>

            <div class="form-group" style="margin-top: 40px; float:right;">
              <button class="btn btn-success" value='0' type='button' id="ht_btnEdit"><i id='tr_i_btnEdit' class="fas fa-edit" style="margin-right: 5px;"></i>Editar</button>
              <button class="btn btn-success" style='display:none' type='button' id="btn_hidraulic"><i class="fas fa-save" style="margin-right: 5px;"></i>Guardar Cambios</button>
            </div>
          </div> <!-- End card body information-->  
        </div> <!-- End card-->
        


        <div class="card">
          <!-- Table medidas-->
          <div class="card-header" >
                <button class="btn btn-link" data-toggle="collapse" data-target="#c2" aria-expanded="true" aria-controls="technicalReportGeneral">
                  <i class="fas fa-table"></i>
                    Mediciones 
                  </button>
          </div>
         
        
          <div class="card-body collapse in " id= "c2">
                <div class="row mb-2  justify-content-end">
                  <div class="col-md-2 mb-2 ">
                    <button class="btn btn-success offset-6 " type='button' data-toggle="modal"    id="btn_config"><i class="fas fa-cog"></i> Configuración</button>
                  </div>
                  <div class="col-md-2 mb-2 ">
                    <button class="btn btn-success offset-6 " type='button' data-toggle="modal"  id="btn_information"><i class="fas fa-plus"></i> Agregar</button>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-bordered" id="table-ht" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                      <th>ID</th>
                      <th>Dato</th>
                      <th>Velocidad</th>
                      <th>Presión</th>
                      <th>Caudal</th>
                      <th>Temperatura</th>
                      <th>Editar</th>
                      <th>Eliminar</th>
                      </tr>
                    </thead>
                  </table>
                </div>
            </div> <!-- End card body medidas-->
        </div><!-- End card-->

        <div class="card">
          <div class="card-header" id="card-option-ht">
              <button class="btn btn-link" data-toggle="collapse" data-target="#c3" aria-expanded="true" aria-controls="technicalReportGeneral">
                  <i class="fas fa-table"></i>
                    Archivos(PDF) 
              </button>
          </div>
   
          <div class="card-body collapse in " id= "c3">
              <div class="row mb-2 " id ="input_pdf">
                <div class="col-md-3 mb-3 ">
                    <form id="pdfs">
                      <input type="file"  name="pdf" id="pdf" data-preview-file-type="any" accept="application/pdf" aria-describedby="inputGroupPrepend3">
                    </form>
                </div>
                <div class="col-md-3 mb-3 offset-2">
                    <button class="btn btn-success " type='button' data-toggle="modal"  id="upload_pdf"><i class="fas fa-file-upload"></i> Subir</button>
                </div>
              </div>

              <div id="actions">
                  <label for="actividad">¿Qué acciones desea realizar sobre el archivo? </label> 
                  <div class="row mb-4 ">
                    <div class="col-md-2 mb-3 ">
                        <button class="btn btn-primary " type='button' data-toggle="modal"  id="show_pdf"><i class="fas fa-file-upload"></i> Ver</button>
                    </div>
                    <div class="col-md-2 mb-3  mr-5 ">
                        <button class="btn btn-danger " type='button' data-toggle="modal"  id="delete_pdf"><i class="fas fa-file-upload"></i> Eliminar</button>
                    </div>
                  </div>
              </div>
          </div><!-- End card body archivos-->
        </div> <!-- End card-->
   </div>
    
  </div>
</div> <!-- End content Evaluation-->
   
  <div class="modal fade bd-example-modal-lg" id="config" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
  <div class="modal-content">
       <div class="modal-header">
           <h5 class="modal-title" id="title">Configuración de información técnica</h5>
           <button type="button" class="close"  data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
            </button>
       </div>
       <div class="modal-body">
             <div class="row mb-2 ">
                 <div class="col-md-3 mb-3 ">
                      
                      <div class="form-check">
                                <input class="form-check-input"  type="checkbox" value=""    id="config_speed" >
                                <label class="form-check-label"  for="config_speed">
                                 Velocidad
                               </label>
                             </div>
                </div>
                <div class="col-md-3 mb-3 ">
                      <div class="form-check">
                                <input class="form-check-input"  type="checkbox"   value="" id="config_presion" >
                                 <label class="form-check-label"  for="config_presion">
                                  Presión
                                </label>
                        </div>
                </div>
                <div class="col-md-3 mb-3 ">
                    <div class="form-check">
                        <input class="form-check-input"  type="checkbox"  value="" id="config_caudal" >
                        <label class="form-check-label"  for="config_caudal">
                         Caudal
                        </label>
                    </div>
                </div>
                <div class="col-md-3 mb-3 ">
                    <div class="form-check">
                        <input class="form-check-input"  type="checkbox"  value="" id="config_time" >
                        <label class="form-check-label"  for="config_time">
                          Temperatura
                        </label>
                    </div>
                </div>
              </div>
          

          <div class="form-group float-right">
               <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
               <button type="button" name ="edit_information" id="save_config" class="btn btn-primary">Guardar</button>
               </div>
               </div>  
</div>
</div>
</div>


  <div class="modal fade bd-example-modal-lg" id="medidas" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
  <div class="modal-content">
          <div class="modal-header bg-gradient-primary " >
               <h5 class="modal-title text-white " id="title_modal" >Agregar datos de medida</h5>
                <button type="button" class="close text-white"  data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
          </div>
          
          <div class="modal-body">
            
                 <div class="card-body">
                  
                    <div class="row mb-2">
              
                        <div class="col-md-4 mb-3">
                          <label for="actividad">Dato</label>
                           <div class="input-group" id='frm_dato'>
                             <input type="text" class="form-control" maxlength="100" name="dato" id="dato">
                             <div class="invalid-feedback"></div>
                          </div>
                       </div>

                       <div class="col-md-4 mb-3">
                          <label for="actividad">Velocidad</label>
                           <div class="input-group" id='frm_speed'>
                             <input type="text" class="form-control" maxlength="100" name="speed" id="speed">
                             <div class="invalid-feedback"></div>
                          </div>
                       </div>

                       <div class="col-md-4 mb-3">
                          <label for="actividad">Presión</label>
                           <div class="input-group" id='frm_presion'>
                             <input type="text" class="form-control"maxlength="100" name="presion" id="presion">
                             <div class="invalid-feedback"></div>
                          </div>
                       </div>
                    </div>
                     
                    <div class="row mb-2">
              
                         <div class="col-md-4 mb-3">
                          <label for="actividad">Caudal</label>
                           <div class="input-group" id='frm_caudal'>
                             <input type="text" class="form-control"maxlength="100" name="caudal" id="caudal">
                             <div class="invalid-feedback"></div>
                          </div>
                         </div>
                  
                  
                         <div class="col-md-4 mb-3">
                          <label for="actividad">Temperatura</label>
                           <div class="input-group" id='frm_time'>
                             <input type="text" class="form-control"maxlength="100" name="time" id="time">
                             <div class="invalid-feedback"></div>
                          </div>
                         </div>
                     </div>
                
              
               <div class="form-group float-right">
               <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
               <button type="button" name ="edit_information" id="edit_information" class="btn btn-primary">Guardar</button>
               </div>
      
               </div>
       <!-- END modal -->     
    </div>
  </div>
</div>


<script src="<?php echo base_url(); ?>assets/js_admin/technical_master/hydraulicTestForm.js"></script>
<script src="<?php echo base_url(); ?>assets/js_admin/file.js"></script>
<script>
$( function() {
    $( "#date_ht").datepicker({
        showOn: "button",
        buttonText: "Calendario",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        buttonImage: host_url + 'assets/img/about/calendario2.png',
    });
  } );</script>
