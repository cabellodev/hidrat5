<div id="content-wrapper">
  <div class="container-fluid mb-5">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Órdenes de trabajo / Administración de OT's</li>
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
            En esta sección podra realizar la administración de órdenes de trabajo , posibilitando el seguimientos de estas en todas las etapas del proceso de una OT.
          </div>
        </div>
      </div>
    </div>
    <div id="accordion">
    <div class="card">
      <div class="card-header" id="headingOne">
        <h5 class="mb-0">
          <button class="btn btn-link" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
              <i class="fas fa-table"></i>
              Información general 
          </button>
        </h5>
      </div>
      <div id="collapseTwo" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
        <div class="card-body">
        <div class="row mb-2">
              <div class="col-md-4 mb-3">
                  <label for="actividad">Numero de OT</label>
                  <div class="input-group" id='frm_ot_number'>
                      <input type="text" class="form-control" name="ot_number" id="ot_number" value='<?= $number_ot ?>' readonly>
                      <div class="invalid-feedback"></div>
                  </div>
              </div>
              <div class="col-md-4 mb-3">
                  <label for="actividad">Fecha de ingreso</label>
                  <div class="input-group" id='frm_date_admission'>
                      <input type="text" class="form-control" name="date_admission" id="date_admission" value='<?= $date ?>' readonly>
                      <div class="invalid-feedback"></div>
                  </div>
              </div>
              <div class="col-md-4 mb-3">
                  <label for="actividad">Empresa</label>
                  <div class="input-group" id='frm_enterprise'>
                      <input type="text" class="form-control" name="enterprise" id="enterprise" value='<?= $enterprise ?>' readonly>
                      <div class="invalid-feedback"></div>
                  </div>
              </div>
          </div>
          <div class="row mb-2">
              <div class="col-md-4 mb-3">
                  <label for="actividad">Tipo de servicio</label>
                  <div class="input-group" id='frm_service'>
                      <input type="text" class="form-control" name="service" id="service" value='<?= $service ?>' readonly>
                      <div class="invalid-feedback"></div>
                  </div>
              </div>
              <div class="col-md-4 mb-3">
                  <label for="actividad">Componente</label>
                  <div class="input-group" id='frm_component'>
                      <input type="text" class="form-control" name="component" id="component" value='<?= $component ?>' readonly>
                      <div class="invalid-feedback"></div>
                  </div>
              </div>
              <div class="col-md-2 mb-3" id='frm_state'>
                  <label>Estado</label>
                  <select class="form-select form-control" name="state" id="state">
                    <?php foreach($states as $item) { 
                      if($state == $item['name']){
                      ?>
                        <option value='<?= $item['id'] ?>' selected="true" name='<?= $item['name'] ?>'><?= $item['name'] ?></option>
                    <?php }else{ ?>  
                       <option value='<?= $item['id'] ?>' name='<?= $item['name'] ?>'><?= $item['name'] ?></option>
                    <?php }} ?>  
                  </select>  
              </div>
              <div class="col-md-2 mb-3" style="margin: auto;">
                  <button id="btn_change_state" type="button" class="btn btn-primary btn-success">Cambiar estado</button>
              </div> 
          </div>
          <div class="row mb-2">
              <div class="col-md-4 mb-3">
                  <label for="actividad">Descripción</label>
                  <div class="input-group">
                      <textarea type="text" class="form-control" rows="1" name="description" id="description" readonly><?= $description ?></textarea>
                  </div>
              </div> 
              <div class="col-md-4 mb-3">
                  <label for="actividad">Prioridad</label>
                  <div class="input-group" id='frm_priority'>
                      <input type="text" class="form-control" name="priority" id="priority" value='<?= $priority ?>' readonly>
                      <div class="invalid-feedback"></div>
                  </div>
              </div> 
              <div class="col-md-2 mb-3" id='frm_state'>
                  <label>Ubicación</label>
                  <input type="text" class="form-control" name="location" id="location" value='<?= $location ?>'>
              </div>
              <div class="col-md-2 mb-3" style="margin: auto;">
                  <button id="btn_change_location" type="button" class="btn btn-primary btn-success">Cambiar ubicación</button>
              </div> 
          </div>
          <div class="row mb-2">
              <div class="col-md-8 mb-3">
                  <label for="actividad">Problema</label>
                  <div class="input-group">
                      <textarea type="text" class="form-control" rows="1" name="description" id="problem" readonly><?= $problem ?></textarea>
                  </div>
              </div> 
              <div class="col-md-2 mb-3"style="margin: auto;">
                 <button class="btn btn-success float-right form-control" type='button'  id="export"><i class="fas fa-search"></i> Exportar</button>
              </div>
              <div class="col-md-2 mb-3" style="margin: auto;">
                 <button class="btn btn-primary float-right form-control" type='button'  id="edit_ot"><i class="fas fa-edit"></i> Editar</button>
              </div>
        </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  
  <?php require('tablesorders.php'); ?>
  <div class="form-group">
    <div class="row mb-2">
      <div class="col-md-12 col-lg-2 control-label">
        <button class="btn btn-success float-right form-control" type='button' id="btn_create"><i class="fas fa-plus"></i> Crear OT</button>
      </div>
      <div class="col-md-12 col-lg-2 control-label">
        <button class="btn btn-success float-right form-control" type='button' data-toggle="modal" id="btn_search"><i class="fas fa-search"></i> Buscar OT</button>
      </div>
    </div>
  </div>
  </div><!--agregar un /div aqui-->

<!-- Modal -->
<div class="modal fade" id="search_ot" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog mw-100 w-75" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Lista de OT's</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="table_orders" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>N° de OT </th>
                  <th>Fecha de ingreso </th>
                  <th>Cliente</th>
                  <th>Componente </th>
                  <th>Estado</th>
                  <th>Tipo de servicio</th>
                  <th>Seleccionar OT</th>
                  <th>Prioridad</th>
                  <th>Descripción</th>
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

<script src="<?php echo base_url(); ?>assets/vendor/fuzzy/fuzzy-autocomplete.js"></script>
<script src="<?php echo base_url(); ?>assets/js_admin/stagesOrder.js"></script>
<script src="<?php echo base_url(); ?>assets/js_admin/export.js"></script>