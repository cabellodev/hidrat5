<div class="conteiner text-center ">
   <h3> <i class="fa fa-th-large" style="font-size: 40px"></i><span>&nbsp;Cómputo subtareas<span></h3>
   <hr>
   <br>
   <div class="row justify-content-center ">


      <div class="card text-white bg-info mb-3 mx-2" style="width: 13rem; height:13rem;">
         <div class="card-header text-center" style="font-weight: bold; color:black;" id="subtask_ev"><strong>0</strong> </div>
         <div class="card-body">
            <h5 class="card-title">Evaluación</h5>
            <button type="button" class="btn btn-outline-light"><i class="fas fa-brain" style="font-size:60px;" ></i></button>
         </div>
      
      </div>
      <div class="card text-white mb-3 mx-3" style="width: 13rem; height:13rem; background-color: #ab47bc">
         <div class="card-header text-center" style="font-weight: bold; color:black" id="subtask_rep"><strong>0</strong></div>
         <div class="card-body">
            <h5 class="card-title">Reparaciones</h5>
            <button type="button" class="btn btn-outline-light"><i class="fa fa-cogs" style="font-size:60px;" ></i></button>
         </div> 
      </div>
   </div>
</div>
  


<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
   <!-- <div class="modal-dialog mw-100 w-75" role="document"> -->
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
                 Lista de subtareas a realizar
               </div>
               <div class="card-body">
                  <div class="table-responsive">
                     <table class="table table-bordered" id="table-orders" width="100%" cellspacing="0">
                        <thead>
                           <tr>
                              <th>OT</th>
                              <th>Fecha</th>
                              <th>Subtarea</th>
                              <th>Acción</th>
                 
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





<script src="<?php echo base_url(); ?>assets/js_admin/technical_assistant/counterAssistant.js"></script>