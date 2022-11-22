<script src="<?php echo base_url(); ?>assets/vendor/fileinput/fileinput.js"></script>
<link href="<?php echo base_url(); ?>assets/vendor/fileinput/fileinput.css" media="all" rel="stylesheet" type="text/css" />


<div id="content-wrapper">
  <div class="container-fluid mb-5">

    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Órdenes de trabajo / En Espera de Aprobación</li>
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
                En esta sección podrá aprobrar la cotización de sus órdenes de trabajo.
          </div>
        </div>
      </div>
    </div>
    <div class="card mb-3">
      <div class="card-header">
        <i class="fas fa-table"></i>
        Lista de Órdenes de trabajo
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="table_orders" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>OT</th>
                <th>Fecha de ingreso</th>
                <th>Componente</th>
                <th>Tipo de servicio</th>
                <th>Estado</th>
                <th>Aprobar</th>
            </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
    <div class="row mb-3"></div>
  </div>
</div>


<!-- Modal Agregar y Editar Empresa -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalApproveOT" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo">Aprobar Cotización</h5>
                <button type="button" class="close" onclick="closeModalApprove()" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group" id="frm_full_name">
                    <label>Adjuntar Órden de Compra (Formato PDF)</label>
                    <form id="ocs">
                      <input type="file"  name="oc" id="oc" data-preview-file-type="any" accept="application/pdf" aria-describedby="inputGroupPrepend3">
                    </form>
                </div>
                <div class="form-group float-right">
                    <button onclick="closeModalApprove()" type="button" class="btn btn-secondary btn-danger">Cerrar</button>
                    <button id="btnSave" type="button" class="btn btn-primary btn-success">Aprobar</button>
                </div>
            </div>
         </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js_client/adminOrdersApprove.js"></script>