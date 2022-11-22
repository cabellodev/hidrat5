<script src="<?php echo base_url(); ?>assets/vendor/fileinput/fileinput.js"></script>
<link href="<?php echo base_url(); ?>assets/vendor/fileinput/fileinput.css" media="all" rel="stylesheet" type="text/css" />


<style type="text/css">
  thead input {
        width: 100%;
    }
</style>

<div id="content-wrapper">
  <div class="container-fluid mb-5">

    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Órdenes de trabajo / Lista general</li>
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
           En esta sección podra realizar la administración de órdenes de trabajo , posibilitanto el seguimientos de estas en todas las etapas del proceso de una OT.
          </div>
        </div>
      </div>
    </div>
    <div class="accordion" id="accordionExample">
      <div class="card mb-3">
        <div class="card-header" id="headingOne">
          <h2 class="mb-0">
          <div style="padding-right: 40px">
            <button class="btn btn-success float-right" type='button' data-toggle="modal" data-target="#addLocation" id="newOrder"><i class="fas fa-plus"></i> Crear OT</button>
          </div>
          </h2>
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
                <th>N° de OT </th>
                <th>Fecha ingreso </th>
                <th>Cliente</th>
                <th>Componente </th>
                <th>Descripción </th>
                <th>Ubicación </th>
                <th>Estado</th>
                <th>Tipo de servicio</th>
                <th>Fecha termino</th>
                <th>Alertas de aprobación</th>
                <th>Administrar</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
    <div class="row mb-3"></div>
  </div>
</div>



<script src="<?php echo base_url(); ?>assets/js_admin/adminOrders.js"></script>