<div id="content-wrapper">
  <div class="container-fluid mb-5">

    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Recursos / Empresas</li>
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
          En esta sección podrá crear, editar y deshabilitar/habilitar empresas.
          </div>
        </div>
      </div>
    </div>

    <div class="card mb-3">
      <div class="card-header">
        <i class="fas fa-table"></i>
        Lista de empresas
        <button class="btn btn-success float-right" type='button' data-toggle="modal" id="btn" data-target="#modal_enterprise"><i class="fas fa-plus"></i> Crear empresa</button>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="list_enterprise" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Rut</th>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Editar</th>
                <th>Des/Habilitar</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
    <!-- Modal Agregar y Editar Empresa -->
    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="modal_enterprise" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titulo">Crear Empresa</h5>
                    <button type="button" class="close" onclick="close_modal_enterprise()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form>
                    <div class="form-group" id="frm_rut">
                        <label>Rut</label>
                        <input type="text" class="form-control" id="rut" name="rut" placeholder="Ingrese rut">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group" id="frm_name">
                        <label>Descripción</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese nombre">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group" id="frm_state" style="display: none">
                        <label>Estado</label>
                        <input type="text" class="form-control" id="state" name="state" readonly>
                    </div>
                    <div class="form-group float-right">
                        <button onclick="close_modal_enterprise()" type="button" class="btn btn-secondary btn-danger">Cerrar</button>
                        <button id="btn_ok" type="button" class="btn btn-primary btn-success">Crear empresa</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url(); ?>assets/js_admin/enterprise.js"></script>
<script src="<?php echo base_url(); ?>assets/js/rut.js"></script>



