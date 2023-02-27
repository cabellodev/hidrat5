<!-- formulario de vista de evaluación para superadmin -->
<div id='reparation_info'>
    <div class="card">
        <div class="card-header" id="headingTR">
            <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#reparationGeneral" aria-expanded="false" aria-controls="technicalReportGeneral">
                <i class="fas fa-table"></i>
                Información general
            </button>
            </h5>
        </div>
        <div id="reparationGeneral" class="collapse show" aria-labelledby="headingTR">
            <div class="card-body">
                <div class="row mb-2 ">
                    <div class="col-md-3 mb-3 ">
                        <div class="form-check">
                                <input class="form-check-input"  type="checkbox" value="" id="r_check_adm" disabled>
                                <label class="form-check-label"  for="r_check_adm">
                                Aprobado por administración
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3 ">
                        <div class="form-check">
                            <input class="form-check-input"  type="checkbox" value="" id="r_check_technical" disabled>
                            <label class="form-check-label"  for="r_check_technical">
                                Aprobado por técnico master
                            </label>
                        </div>
                    </div>   
                    <div class="col-md-6 mb-3" style='text-align: right;'>
                        <button id="r_popover" type="button" class="btn btn-primary rounded-circle" data-toggle="popover" data-placement="left"><i class="fas fa-info"></i></button>
                        <button id="send_notification_rep" type="button" class="btn btn-success rounded-circle" data-toggle="popover" data-placement="left"><i class="fas fa-edit"></i></button>
                    </div>               
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-3">
                        <label for="actividad">Fecha de inicio</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="r_date_assignment" id="r_date_assignment" readonly>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Técnico asignado para la reparación</label>
                        <select class="form-select form-control" id="r_technical" name="r_technical" disabled>
                            <option></option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Días de reparación</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="r_days_reparation" id="r_days_reparation" readonly>
                        </div>
                    </div>
                </div> 
                <div class="row mb-2">
                    <div class="col-md-4 mb-3">
                        <label for="actividad">Fecha de Limite</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="r_date_limite" id="r_date_limite" readonly>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3" >
                        <label for="actividad">Tipo de prioridad</label>
                        <select class="form-select form-control"  id="priority_rep" name="priority_rep" required="" disabled>
                            <option></option>
                            <option value="1">BAJA</option>
                            <option value="2">MEDIA</option>
                            <option value="3">ALTA</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div> 
                    <div class="col-md-4 mb-3">
                        <label for="actividad">Fecha de reparación</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="r_date_reparation" id="r_date_reparation" readonly>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingTR">
            <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#reparationPedido" aria-expanded="false" aria-controls="technicalReportGeneral">
                <i class="fas fa-table"></i>
                Información de pedido
            </button>
            </h5>
        </div>
        <div id="reparationPedido" class="collapse" aria-labelledby="headingTR">
            <div class="card-body">
                <div class="row mb-2 ">
                    <div class="col-md-4 mb-3">
                        <label for="actividad">Fecha de pedido</label>
                        <div class="input-group" id="frm_date_provider_number">
                            <input type="text" class="form-control" value="" name="date_provider_number" id="date_provider_number" readonly>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                    <label for="actividad">Número de pedido</label>
                        <div class="input-group" id="frm_provider_number">
                            <input type="number" min="0" class="form-control" value="" name="provider_number" id="provider_number" readonly>
                        </div>
                    </div>              
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header" id="headingTR">
            <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#reparationSubtareas" aria-expanded="false" aria-controls="technicalReportGeneral">
                <i class="fas fa-table"></i>
                Subtareas
            </button>
            </h5>
        </div>
        <div id="reparationSubtareas" class="collapse" aria-labelledby="headingTR">
            <div class="card-body">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    Lista de Subtareas asociadas a la OT
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table table-bordered" id="table_reparation_subtask" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id </th>
                                <th>Fecha</th>
                                <th>Subtarea</th>
                                <th>Ayudante Tecnico</th>
                                <th>Realizado por Ayudante técnico </th>
                                <th>Aprobado por Técnico Master</th>
                                <th>Estado </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group" style="margin-top: 40px; display: flex; align-items:center; justify-content: center;">
        <button class="btn btn-success" value='0' type='button' id="r_btnEdit"><i id='r_i_btnEdit' class="fas fa-edit" style="margin-right: 5px;"></i>Editar</button>
        <button class="btn btn-success" style='display:none' type='button' id="r_btnSave"><i class="fas fa-save" style="margin-right: 5px;"></i>Guardar Cambios</button>
    </div>
</div>



<div class="modal fade bd-example-modal-lg" id="modal_notification_rep" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                  <textarea type="text" class="form-control" id="notification_manual_rep" name="name" placeholder="Escriba aqui..."></textarea>
                  <div class="invalid-feedback"></div>
              </div>
              <div class="form-group float-right">
                <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" id="send_technical_rep" class="btn btn-primary">Enviar</button>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url(); ?>assets/js_admin/reparation.js"></script>

