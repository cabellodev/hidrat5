<div class="table-responsive tab-pane fade  " id="aprobation" >
    <div role="alert" id="alert_aprobation">
        <strong id="title_alert_ap"></strong>
    </div>
    <div id="accordion">
      <div id="aprobation_info" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
    
        <div class="card">
          <div class="card-header" >
            <button class="btn btn-link" data-toggle="collapse"  data-target="#ap1" aria-expanded="true">
                  <i class="fas fa-table"></i>
                  Información de cotización
            </button> 
          </div>

          <div class="card-body collapse show"  id= "ap1">
              <input type="hidden" class="form-control" id="user_modify_ap" name="id" >
              <input type="hidden" class="form-control" id="date_modify_ap" name="id" >
              <input type="hidden" class="form-control" id="user_approve_ap" name="id" >
              <input type="hidden" class="form-control" id="date_approve_ap" name="id" >
              <input type="hidden" class="form-control" id="date_send_email" name="id" >


              <div class="row mb-2 ">
                  <div class="col-md-3 mb-3">
                      <div class="form-check">
                        <input class="form-check-input"  type="checkbox" value="" id="approve_client" disabled>
                        <label class="form-check-label"  for="approve_client"> Aprobación Cliente </label>
                      </div>
                  </div>
                  <div class="col-md-9 mb-3" style='text-align: right;'>
                      <button id="ap_popover" type="button" class="btn btn-primary rounded-circle" data-toggle="popover" data-placement="left"><i class="fas fa-info"></i></button>
                  </div>               
              </div>

              <div class="row mb-2 ">
                <div class="col-md-3 mb-3">
                  <label for="actividad">Fecha de cotización</label>
                  <div class="input-group" id='frm_send_quotation'>
                      <input type="text" class="form-control" name="date_send" id="date_send_qt" disabled>
                      <div class="invalid-feedback"></div>
                  </div>
                </div>
              </div>

              <div class="row mb-2 ">
                <div class="col-md-3 mb-3">
                  <label for="actividad">Fecha de aprobación de cotización</label>
                  <div class="input-group" id='frm_date_admission'>
                      <input type="text" class="form-control" name="date_ap" id="date_ap" disabled>
                      <div class="invalid-feedback"></div>
                  </div>
                </div>
                <div class="col-md-3 mb-3">
                  <label for="actividad">Número de cotización</label>
                  <div class="input-group" id='number_quotation'>
                      <input type="number" class="form-control" min="1" pattern="^[0-9]+" name="number_qt" id="number_qt" disabled>
                      <div class="invalid-feedback"></div>
                  </div>
                </div>              
              </div>

              <div class="row mb-2" style="float:right;">
                <div class="form-group" style="margin-top: 40px; float:right;">
                  <button class="btn btn-success" value='0' type='button' id="hab_edit_ap"><i id='ap_i_btnEdit' class="fas fa-edit" style="margin-right: 5px;"></i>Editar</button>
                  <button class="btn btn-success" style='display:none' type='button' id="btn_aprobation"><i class="fas fa-save" style="margin-right: 5px;"></i>Guardar Cambios</button>
                </div>
              </div>
          </div>
        </div> <!-- End card-->
          
        <div class="card">
          <div class="card-header">
            <button class="btn btn-link" data-toggle="collapse" data-target="#ap2" aria-expanded="true" aria-controls="technicalReportGeneral">
                <i class="fas fa-table"></i>
                Orden de compra 
            </button>
          </div>
          <div class="card-body collapse in " id= "ap2">
            <div class="row mb-2 " id ="input_oc">
                  <div class="col-md-3 mb-3 ">
                    <form id="ocs">
                      <input type="file"  name="oc" id="oc" data-preview-file-type="any" accept="application/pdf" aria-describedby="inputGroupPrepend3">
                    </form>
                  </div>
                  <div class="col-md-3 mb-3 offset-2">
                          <button class="btn btn-success " type='button' data-toggle="modal"  id="upload_oc"><i class="fas fa-file-upload"></i> Subir</button>
                  </div>
            </div>
            <div id="actions_oc">
                <label for="actividad">¿Qué acciones desea realizar sobre el archivo? </label> 
                <div class="row mb-4 ">
                      <div class="col-md-2 mb-3 ">
                          <button class="btn btn-primary " type='button' data-toggle="modal"  id="show_oc"><i class="fas fa-file-upload"></i> Ver</button>
                      </div>
                      <div class="col-md-2 mb-3  mr-5 ">
                          <button class="btn btn-danger " type='button' data-toggle="modal"  id="delete_oc"><i class="fas fa-file-upload"></i> Eliminar</button>
                      </div>
                </div>
            </div> 
          </div>
        </div><!-- End card-->
            
      </div> <!-- End aprobation info-->
    </div> <!-- End acordion-->
</div> <!-- End table responsive-->
 
   
<script src="<?php echo base_url(); ?>assets/js_admin/aprobation.js"></script>
<script src="<?php echo base_url(); ?>assets/js_admin/order_c.js"></script>



    