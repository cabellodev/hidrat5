<!-- formulario de vista de evaluación para superadmin -->
<div role="alert" id="alert_technical_report">
    <strong id="tr_title_alert"></strong>
</div>
<div id='technical_report_info'>

    <div class="card">
        <div class="card-header" id="headingTR">
            <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#technicalReportGeneral" aria-expanded="false" aria-controls="technicalReportGeneral">
                <i class="fas fa-table"></i>
                Información general
            </button>
            </h5>
        </div>
        <div id="technicalReportGeneral" class="collapse show" aria-labelledby="headingTR">
            <div class="card-body">
                <div class="row mb-2 ">
                    <div class="col-md-3 mb-3 ">
                        <!-- <div class="form-check">
                                <input class="form-check-input"  type="checkbox" value="" id="tr_check_adm" disabled>
                                <label class="form-check-label"  for="tr_check_adm">
                                Aprobado por administración
                            </label>
                        </div> -->
                    </div>
                    <div class="col-md-3 mb-3 ">
                      <!--   <div class="form-check">
                            <input class="form-check-input"  type="checkbox" value="" id="tr_check_technical" disabled>
                            <label class="form-check-label"  for="tr_check_technical">
                                Aprobado por técnico master
                            </label>
                        </div> -->
                    </div>
                    <div class="col-md-6 mb-3" style='text-align: right;'>
                        
                        <button id="tr_export" style='display: none;' type="button" class="btn btn-primary rounded-circle" data-toggle="popover" data-placement="left"><i class="fas fa-file-export"></i></i></button>
                        <button id="tr_popover" type="button" class="btn btn-primary rounded-circle" data-toggle="popover" data-placement="left"><i class="fas fa-info"></i></button>
                        <button id="send_notification_tr" type="button" class="btn btn-success rounded-circle" data-toggle="popover" data-placement="left"><i class="fas fa-edit"></i></button>
                    </div>                  
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-3">
                        <label for="actividad">Fecha de reporte técnico</label>
                        <div class="input-group" id='frm_date_technical_report'>
                            <input type="text" class="form-control" name="tr_date_technical_report" id="tr_date_technical_report"  readonly>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3" id="frm_technical">
                        <label>Técnico asignado para el reporte técnico</label>
                        <select class="form-select form-control" id="tr_technical" name="tr_technical" disabled>
                            <option></option>
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-8 mb-3">
                        <div>
                            <label for="actividad">Detalles</label>
                            <div class="input-group">
                                <textarea type="text" class="form-control" rows="3" name="tr_details" id="tr_details" placeholder="" aria-describedby="inputGroupPrepend3" readonly></textarea>
                            </div>
                        </div>
                        </br>
                        <div>
                            <label>Notas</label>
                            <div class="input-group">
                                <textarea type="text" class="form-control" rows="3" name="tr_notes" id="tr_notes" placeholder="" aria-describedby="inputGroupPrepend3" readonly></textarea>
                            </div>
                        </div>
                    </div>  
                    <div class="col-md-4 mb-3" style='text-align: center;'>
                        <label id='tr_label_image_header'>Imagen Cabecera</label>
                        <button id='tr_btn_image_header' onclick='loadImages(null)' style='display:none; margin-bottom:5px;' class='btn btn-primary'><i class='fas fa-plus'></i>Seleccione imagen</button>
                        <div class="input-group">
                            <img id='tr_image_header' style='display:block;margin:auto;' src='' width="250" heigth="250">
                        </div>
                    </div>
                </div>   
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="headingOne">
            <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#technicalReportDetails" aria-expanded="true" aria-controls="technicalReportGeneral">
                <i class="fas fa-table"></i>
                Detalle Informe Técnico
            </button>
            </h5>
        </div>
        <div id="technicalReportDetails" class="collapse" aria-labelledby="headingOne">
            <div class="card-body" id='tr_images'>
            </div>
            <div id='tr_div_add' name='tr_add' style='margin-bottom:15px; margin-top:-15px; display:none;'>
                <div style="text-align: center;">
                    <button id='tr_btn_add' class="btn btn-primary rounded-circle"><i class="fas fa-plus"></i></button>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="headingOne">
            <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#technicalReportConclusion" aria-expanded="true" aria-controls="technicalReportGeneral">
                <i class="fas fa-table"></i>
                Conclusiones y recomendaciones
            </button>
            </h5>
        </div>
        <div id="technicalReportConclusion" class="collapse" aria-labelledby="headingOne" >
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-6 mb-3">
                        <label for="actividad">Conclusiones</label>
                        <div class="input-group">
                            <textarea type="text" class="form-control" rows="2" name="tr_conclusion" id="tr_conclusion" placeholder="" aria-describedby="inputGroupPrepend3" readonly></textarea>
                        </div>
                    </div>  
                    <div class="col-md-6 mb-3">
                        <label for="actividad">Recomendaciones</label>
                        <div class="input-group">
                            <textarea type="text" class="form-control" rows="2" name="tr_recommendation" id="tr_recommendation" placeholder="" aria-describedby="inputGroupPrepend3" readonly></textarea>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3" >
                <div class="form-check">
                        <input class="form-check-input"  type="checkbox" value="" id="tr_check_adm" disabled>
                        <label class="form-check-label"  for="tr_check_adm">
                        Aprobado por administración
                    </label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-input"  type="checkbox" value="" id="tr_check_technical" disabled>
                    <label class="form-check-label"  for="tr_check_technical">
                        Aprobado por técnico master
                    </label>
                </div>
            </div>
        </div>
        <div class="row"   style ="float:right;">
            <div class="form-group" style="margin-top: 40px; float:right;">
                <button class="btn btn-success" value='0' type='button' id="tr_btnEdit"><i id='tr_i_btnEdit' class="fas fa-edit" style="margin-right: 5px;"></i>Editar</button>
                <button class="btn btn-success" style='display:none' type='button' id="tr_btnSave"><i class="fas fa-save" style="margin-right: 5px;"></i>Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>


<!-- Modals -->

<!---   modal preview image ---->
<div class="modal fade" id="tr_show_image" style='z-index: 2000' tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">              
      <div class="modal-body" >
      	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <img src="" class="imagepreview" style="width: 100%;" >
      </div>
    </div>
  </div>
</div>

<!---   modal user interaction ---->
<div class="modal fade" id="tr_user_interaction" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row mb-2">
            <div class="col-md-6 mb-3">
                <label for="actividad">Fecha de creación</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="tr_date_create"  readonly>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="actividad">Usuario responsable</label>
                <div class="input-group" id='frm_date_technical_report'>
                    <input type="text" class="form-control" id="tr_user_create"  readonly>
                </div>
            </div>
        </div>
        <hr>
        <div class="row mb-2">
            <div class="col-md-6 mb-3">
                <label>Fecha de última modificación</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="tr_date_modify"  readonly>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label>Usuario responsable</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="tr_user_modify"  readonly>
                </div>
            </div>
        </div>
        <hr>
        <div class="row mb-2">
            <div class="col-md-6 mb-3">
                <label>Fecha de aprobación</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="tr_date_approve"  readonly>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label>Usuario responsable</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="tr_user_approve"  readonly>
                </div>
            </div>
        </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
  </div>
</div>

<!---   modal images ---->
<div class="modal fade" id="tr_search_image" style='z-index: 1999' tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog mw-100 w-75" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Lista de Imagenes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="tr_table_images" width="100%" cellspacing="0">
              <thead>
                <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Ver</th>
                <th>Seleccionar</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade bd-example-modal-lg" id="modal_notification_tr" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="title">Enviar notificación</h5>
        <button type="button" class="close"  data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm">
            <p id="UserModalInfo"></p>
          </div>
        </div>
        <div class="form-group">
          <form>
              <input type="hidden" class="form-control" id="id" name="id" >
              <div class="form-group" id="frm_name">
                  <label>Cuerpo de notificación</label>
                  <textarea type="text" class="form-control" id="notification_manual_tr" name="name" placeholder="Escriba aqui..."></textarea>
                  <div class="invalid-feedback"></div>
              </div>
              <div class="form-group float-right">
                <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" id="send_technical_tr" class="btn btn-primary">Enviar</button>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url(); ?>assets/js_admin/technicalReport.js"></script>

