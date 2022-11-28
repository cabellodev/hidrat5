<div id="content-wrapper">
  <div class="container-fluid mb-5">

    <ol class="breadcrumb">
      <li class="breadcrumb-item active" id="header-title">Órdenes de trabajo</li>
    </ol>
    
    
    <div class="card mb-3">
      <div class="card-header">
        <i class="fas fa-table"></i>
        Consulta de órdenes por clientes
      </div>
      <div class="card-body">
              <div class="row">
                  <div class="col-md-6 mb-3" id="frm_priority">
                        <label for="actividad">Buscar cliente (filtro avanzado)</label>
                        <input type="text" class="form-control" name="ot_number" id="enterprise" placeholder="" aria-describedby="inputGroupPrepend3">
                       <!-- <select class="custom-select d-block w-100" id="enterprise" name="priority" required="">
                           <option value="0"></option>
                        </select> -->
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-2 mb-2 mt-4" id="search"> 
                           <button type="button" id="btn_orders" class="btn btn-primary"><i class="fas fa-search"></i></button>
                           <button type="button" id="btn_list" class="btn btn-primary"><i class="fas fa-list"></i> </button>
                    </div>   
              </div> 
              <br>

              <div class="row">
                    <div class="col-md-6 mb-3" id="frm_priority">
                     
                        <input type="text" class="form-control" name="client_name" id="client_name" placeholder="Cliente" aria-describedby="inputGroupPrepend3"disabled>
                  <!--      <select class="custom-select d-block w-100" id="enterprise" name="priority" required="">
                           <option value="0"></option>
                        </select>-->
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-2 mb-2"> 
                        <button type="button" onclick=getOrderFail(); class="btn btn-primary"><i class="fas fa-broom"></i></button>
                        <div class="invalid-feedback"></div>
                    </div>

              </div>
              
              
              <br>

              <div class="card mb-3">
      <div class="card-header">
        <i class="fas fa-table"></i>
        Lista de órdenes
      </div>
      
      <div class="card-body">
              <div class="row justify-content" >
                 <div class="col-md-12 mb-3" >
                   <div class="table-responsive">
                      <table class="table table-bordered" id="table-clients" width="100%" cellspacing="0">
                       <thead>
                            <tr>
                            <th>OT</th>
                   <!--         <th> Correlative </th>-->
                           <th>Fecha de ingreso </th>
                           <th>Tipo </th>
                           <th>Descripción</th>
                           <th>Servicio</th>
                           <th>Estado</th>
                           <th>Cotización</th>
                           <th>Aprobar/Pendiente</th>
                           <th>Orden de compra</th> 
                           <th>Detalles</th> 
                        </tr>
                  </thead>
               </table>
             </div>
             </div>
            </div> <!-- Fin row datatables-->
            </div>
             </div>
</div>
      </div>
    </div>
</div>


<div class="modal fade bd-example-modal-lg" id="clients" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
<div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="title">Listado de clientes</h5>
               <button type="button" class="close"  data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
      <div class="modal-body">
      <div class="col-md-12 mb-3" >
                   <div class="table-responsive">
                      <table class="table table-bordered" id="table-list" width="100%" cellspacing="0">
                       <thead>
                            <tr>
                            <th>Rut</th>
                   <!--         <th> Correlative </th>-->
                           <th>Cliente </th>
                           <th>Seleccionar </th>
                        </tr>
                  </thead>
               </table>
             </div>
             </div>
        
         </div> <!-- End card body archivos-->
        
</div>
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
        <input type="hidden" class="form-control" id="id_client" name="id" >
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
<script src="<?php echo base_url(); ?>assets/vendor/fuzzy/fuzzy-autocomplete.js"></script>
<script src="<?php echo base_url(); ?>assets/js_admin/seller/adminClient.js"></script>

