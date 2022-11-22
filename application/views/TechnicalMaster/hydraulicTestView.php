<input type="hidden" class="form-control" id="ot_number" name="ot_number" value='<?= $id ?>' >
    <div id="content-wrapper">
    <div class="container-fluid mb-5" id="adminColors">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Prueba hidráulica</li>
            <li class="breadcrumb-item active">OT NÚMERO <?php echo $id; ?></li>
        </ol>

        <div class="card mb-3">
            <div class="card-header">
         </div>
        <div class="card-body">
         <div class="card-header" >
           <button class="btn btn-link" data-toggle="collapse" data-target="#c1" aria-expanded="true" aria-controls="technicalReportGeneral">
                <i class="fas fa-table"></i>
                Información 
                </button>
              
         </div>
        <div class="card-body collapse in " id= "c1">
        <input type="hidden" class="form-control" id="speed_c" name="id" >
        <input type="hidden" class="form-control" id="caudal_c" name="id" >
        <input type="hidden" class="form-control" id="presion_c" name="id" >
        <input type="hidden" class="form-control" id="temperature_c" name="id" >
        <input type="hidden" class="form-control" id="technical_aux" name="technical_aux" >
     

        <input type="hidden" class="form-control" id="user_create" name="id" >
        <input type="hidden" class="form-control" id="date_create" name="id" >
        <input type="hidden" class="form-control" id="user_modify" name="id" >
        <input type="hidden" class="form-control" id="date_modify" name="id" >
        <input type="hidden" class="form-control" id="user_approve" name="id" >
        <input type="hidden" class="form-control" id="date_approve" name="id" >
        <input type="hidden" class="form-control" id="technical_name_ht" name="id" >

        
        
             <div class="row mb-2 ">
                
                      
                <div class="form-check">
                                <input class="form-check-input"  type="hidden" value="" id="approve_admin_ht" disabled>
                                <label class="form-check-label"  for="approve_admin_ht">
                               </label>
                </div>
                    
                <div class="col-md-2 mb-3 ">
                 
                      <div class="form-check">
                           <input class="form-check-input"  type="checkbox" value="" id="approve_technical_ht" disabled>
                           <label class="form-check-label"  for="approve_technical_ht">
                            Aprobado por técnico master
                          </label>
                        </div>
                     </div>

                 
             </div>
          
   
              <div class="row mb-2">
            
                <div class="col-md-8 mb-3">
                  <label for="actividad">Componente</label>
                    <div class="input-group">
                      <textarea type="text" class="form-control" rows="2" style="background:white" name="notes_ht" id="notes_ht" placeholder="" aria-describedby="inputGroupPrepend3" disabled></textarea>
                        <div class="invalid-feedback descripcion" style="display: none;  color:red">
                                Ingrese una descripción porfavor.
                        </div>
                  </div>
                </div>  
             
              </div>
              <div class="row mb-2">
                
                <div class="col-md-12 mb-3">
                  <label for="actividad">Conclusiones</label>
                    <div class="input-group">
                      <textarea type="text" class="form-control" rows="2"style="background:white" name="conclusion_ht" id="conclusion_ht" placeholder="" aria-describedby="inputGroupPrepend3" disabled></textarea>
                        <div class="invalid-feedback descripcion" style="display: none;  color:red">
                                Ingrese una descripción porfavor.
                        </div>
                      </div>
                </div> 
              </div>

             
          </div>  <!-- End card body information-->
           <!-- Table medidas-->
           <div class="card-header" >
                 <button class="btn btn-link" data-toggle="collapse" data-target="#c2" aria-expanded="true" aria-controls="technicalReportGeneral">
                    <i class="fas fa-table"></i>
                     Mediciones 
                   </button>
           </div>
         
        
         <div class="card-body collapse in " id= "c2">
       
             <div class="table-responsive">
             <table class="table table-bordered" id="table-ht-view" width="100%" cellspacing="0">
              <thead>
                <tr>
                   <th>ID</th>
                   <th>Dato</th>
                   <th>Velocidad</th>
                   <th>Presión</th>
                   <th>Caudal</th>
                   <th>Temperatura</th>
            
                </tr>
              </thead>
             </table>
             </div>
          <!-- Table medidas END -->
        </div> <!-- End card body medidas-->
  
   
        <div class="card-header" id="card-option-ht">
             <button class="btn btn-link" data-toggle="collapse" data-target="#c3" aria-expanded="true" aria-controls="technicalReportGeneral">
                  <i class="fas fa-table"></i>
                  Archivos(PDF) 
                  </button>
        </div>
   
        <div class="card-body collapse in " id= "c3">
              <div class="row mb-2 " id ="input_pdf">
                <div class="col-md-3 mb-3 ">
                 
                       <form id="pdfs">
                       <input type="file"  name="pdf" id="pdf" data-preview-file-type="any" accept="application/pdf" aria-describedby="inputGroupPrepend3">
                     </form>
                 </div>
                 <div class="col-md-3 mb-3 offset-2">
                      <button class="btn btn-success " type='button' data-toggle="modal"  id="upload_pdf"><i class="fas fa-file-upload"></i> Subir</button>
                </div>
              </div>

              <div id="actions">
      
                 <label for="actividad">¿Qué acciones desea realizar sobre el archivo? </label> 
                   <div class="row mb-4 ">
                 
                          <div class="col-md-2 mb-3 ">
                             <button class="btn btn-primary " type='button' data-toggle="modal"  id="show_pdf"><i class="fas fa-file-upload"></i> Ver</button>
                          </div>
                         
                     </div>
              </div>
         </div>
 
   
   </div>
    <!-- End card body archivos-->
    </div> 
    </div>
    </div> <!-- End content Evaluation-->
   
  

  
 <script src="<?php echo base_url(); ?>assets/js_admin/technical_master/hydraulicTestForm_v.js"></script>
<script src="<?php echo base_url(); ?>assets/js_admin/technical_master/file_ht.js"></script>

