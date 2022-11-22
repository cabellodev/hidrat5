


<div id="content-wrapper">
  <div class="container-fluid mb-5">

    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Órdenes de trabajo / Órdenes en E.aprobación</li>
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
           En esta sección podra realizar la administración de órdenes de trabajo en espera de aprobación , posibilitanto realizar acciones sobres estas como : aprobación de cotizaciones y carga de órdenes de compra de clientes.
          </div>
        </div>
      </div>
    </div>
    
    <div class="card mb-3">
      <div class="card-header">
        <i class="fas fa-table"></i>
        Lista de reportes técnicos aprobados
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="table_orders" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>N° de OT </th>
                <th>Fecha de creación </th>
                <th>Cliente</th>
                <th>Componente </th>
                <th>Estado</th>
                <th>Tipo de servicio</th>
                <th>Ver</th>
                
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
    <div class="row mb-3"></div>
  </div>
</div>



<script src="<?php echo base_url(); ?>assets/js_admin/seller/ordersApproved.js"></script>