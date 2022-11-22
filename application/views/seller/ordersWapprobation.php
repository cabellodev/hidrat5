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
        Lista de órdenes en espera de aprobación
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="table-order" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>N° de OT </th>
                <th>Fecha de ingreso </th>
                <th>Cliente</th>
                <th>Componente </th>
                <th>Estado</th>
                <th>Tipo de servicio</th>
                <th>Check</th>
                <th>Aprobar/Pendiente</th>
                <th>Orden de compra</th>
                
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
    <div class="row mb-3"></div>
  </div>
</div>



<div class="modal fade bd-example-modal-lg" id="modal_oc" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
<div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="title">Archivo de orden de compra</h5>
               <button type="button" class="close"  data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
      <div class="modal-body">
       
        <input type="hidden" class="form-control" id="id" name="id" >
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
        
         </div> <!-- End card body archivos-->
         </div>
</div>
</div>
</div>


<script src="<?php echo base_url(); ?>assets/js_admin/seller/ordersWapprobation.js"></script>