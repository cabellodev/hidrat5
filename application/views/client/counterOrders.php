<div class="conteiner text-center ">
   <h3> <i class="fa fa-th-large" style="font-size: 40px"></i><span>&nbsp;Cómputo General<span></h3>
   <hr>
   <br>
   <div class="row justify-content-center">
      <div class="card text-white  mb-3 mx-3" style="width: 13rem; height:13rem; background:#00897b">
         <div class="card-header text-center counter" style="font-weight: bold; color:black" id="process"><strong>0</strong></div>
         <div class="card-body">
            <h5 class="card-title"> En Proceso</h5>
            <button type="button" class="btn btn-outline-light"><i class="fa fa-cogs" style="font-size:60px;" id="btnProcess"></i></button>
         </div> 
      </div>
      <div class="card text-white  mb-3 mx-3" style="width: 13rem; height:13rem; background:#36b9cc">
         <div class="card-header text-center counter" style="font-weight: bold; color:black" id="ready_retirement"><strong>0</strong> </div>
         <div class="card-body">
            <h5 class="card-title"> Listo Para Retiro</h5>
            <button type="button" class="btn btn-outline-light"><i class="fas fa-truck" style="font-size:60px;" id="btnRetirement"></i></button>
         </div> 
      </div>
      <div class="card text-white  mb-3 mx-3" style="width: 13rem; height:13rem; background: #ffa726">
         <div class="card-header text-center counter" style="font-weight: bold; color:black" id="finished"><strong>0</strong> </div>
         <div class="card-body">
            <h5 class="card-title"> Terminadas</h5>
            <button type="button" class="btn btn-outline-light"><i class="fa fa-check-circle" style="font-size:60px;" id="btnFinished"></i></button>
         </div>
      </div>
      <div class="card text-white bg-danger mb-3 mx-3" style="width: 13rem; height:13rem;">
         <div class="card-header text-center counter" style="font-weight: bold; color:black" id="down"><strong>0</strong></div>
         <div class="card-body">
            <h5 class="card-title">De Baja </h5>
            <button type="button" class="btn btn-outline-light"><i class="fa fa-thumbs-down" style="font-size:60px;" id="btnDown"></i></button>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog mw-100 w-75"  role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="titlemodal"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="card mb-3">
               <div class="card-header">
                  <i class="fas fa-table"></i>
                  Órdenes
               </div>
               <div class="card-body">
                  <div class="table-responsive">
                     <table class="table table-bordered" id="table-orders" width="100%" cellspacing="0">
                        <thead>
                           <tr>
                              <th>OT</th>
                              <th>Fecha de ingreso</th>
                              <th>Componente</th>
                              <th>Tipo de servicio</th>
                              <th>Estado</th>
                           </tr>
                        </thead>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
         </div>
      </div>
   </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/counterUp/jquery.counterup.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js_client/counterOrder.js"></script>

