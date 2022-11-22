<!-- formulario de vista de evaluación para superadmin -->
<div role="alert" id="alert_technical_report">
    <strong id="tr_title_alert"></strong>
</div>
<div id='technical_report_info'>

    <div class="card">
        <div class="card-header" id="headingTR">
            <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#technicalReportGeneral" aria-expanded="true" aria-controls="technicalReportGeneral">
                <i class="fas fa-table"></i>
                Información general 
            </button>
            </h5>
        </div>
        <div id="technicalReportGeneral" class="collapse show" aria-labelledby="headingTR">
            <div class="card-body">
            <div class="row mb-2 ">
                    <div class="col-md-3 mb-3 ">
                        <div class="form-check">
                                <input class="form-check-input"  type="checkbox" value="" id="tr_check_adm" disabled>
                                <label class="form-check-label"  for="tr_check_adm">
                                Aprobado por administración
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3 ">
                        <div class="form-check">
                            <input class="form-check-input"  type="checkbox" value="" id="tr_check_technical" disabled>
                            <label class="form-check-label"  for="tr_check_technical">
                                Aprobado por técnico master
                            </label>
                        </div>
                    </div> 
                    <div class="col-md-6 mb-3" style='text-align: right;'>
                        <button id="tr_export" style='display: none;' type="button" class="btn btn-primary rounded-circle" data-toggle="popover" data-placement="left"><i class="fas fa-file-export"></i></i></button>
                        <button id="tr_popover" type="button" class="btn btn-primary rounded-circle" data-toggle="popover" data-placement="left"><i class="fas fa-info"></i></button>
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
        <div id="technicalReportDetails" class="collapse show" aria-labelledby="headingOne">
            <div class="card-body" id='tr_images'>
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
        <div id="technicalReportConclusion" class="collapse show" aria-labelledby="headingOne" >
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
<script src="<?php echo base_url(); ?>assets/js_admin/technicalReport.js"></script>

