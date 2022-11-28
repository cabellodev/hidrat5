<div id="content-wrapper">
  <div class="container-fluid mb-5">

    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Biblioteca / Administración</li>
    </ol>
   <section id="template_library" style="display:none">

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
           En esta sección podrá realizar la subida, lectura y otras acciones sobre documentaciones técnicas pertenecientes a la biblioteca privada de la empresa.
          </div>
        </div>
      </div>
    </div>

    

    <div class="card mb-3">
      <div class="card-header">
        <i class="fas fa-edit"></i>
        Registro de documento
        <button type="button" id="btn_create_tag" class="btn btn-primary float-right">+ Agregar tags</button>
      </div>
      <div class="card-body">


           <div class="row mb-3 " >
                <div class="col-md-6 mb-3">
                    <label for="actividad">Nombre del documento</label>
                      <div class="input-group" id='frm_date_admission'>
                          <input type="text" class="form-control" name="date_ap" id="doc_name" >
                          <div class="invalid-feedback"></div>
                      </div>
                </div>

                <div class="col-md-6 mt-4 ">
                       <form id="ocs">
                       <div class= "custom-input" id= 'custom-file-create' >
                           <input type="file" class="custom-file-input" name="oc" id="oc" data-preview-file-type="any" accept="application/pdf" aria-describedby="inputGroupPrepend3">
                           <label class="custom-file-label " id='label-file-create' for="file">Elegir imágenes</label>
                        </div>
                           
                       </form>
                 </div>
              
            </div>

            <label for="actividad">Seleccione tags para el documento:</label>
            <div class="row my-3"  >
                
               <div class="col-md-10 mb-3 " id="tags_space" >
                 
               </div> 
           </div>

           
          
                        
                   <div style="margin-right: 40px; margin-bottom: 40px;">
                        <button type="button" id="btn_create_doc" class="btn btn-success float-right ">Guardar</button>
                  </div>
              
        </div> <!-- card body-->
        </div> 


        <div class="card mb-3">
          <div class="card-header">
               <i class="fas fa-table"></i>
                 Lista de documentos registrados
          </div>
      
        <div class="card-body">
             <div class="table-responsive">
                  <table class="table table-library" id="table-document" width="100%" cellspacing="0">
                      <thead>
                          <tr>
                            <th>Nombre</th>
                            <th>Tags</th>
                            <th>Visualizar</th>
                            <th>Editar</th>
                            <th>Deshabilitar</th>
                       
                          </tr>
                       </thead>
                  </table>
              </div>
          </div>
        </div>
</section>

   <div class="alert alert-info" id="alert-active" > No tienes los privilegios necesarios para manipular esta sección. Comunicate con el super administrador.</div>
    
  </div>
</div>



<!----------------------------------------------------------------- modal create tag-------------------------------------------------------------------------------------------------------->

<div class="modal fade bd-example-modal-lg" id="modal_create_tag" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
<div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="title">Crear tag</h5>
               <button type="button" class="close"  data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
      <div class="modal-body">
          <div class="col-md-6 mb-3">
                  <label for="actividad">Nombre tag</label>
                  <div class="input-group" id='frm_date_admission'>
                      <input type="text" class="form-control"  id="name_tag" >
                      <div class="invalid-feedback"></div>
                  </div>
                </div>


          <div class="form-group float-right">
                <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" id="btn_save_tag" class="btn btn-primary">Guardar</button>
              </div>
         </div> <!-- End card body archivos-->
</div>
</div>
</div>



<!----------------------------------------------------------------- modal update tag-------------------------------------------------------------------------------------------------------->
<div class="modal fade bd-example-modal-lg" id="modal_edit_tag" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
<div class="modal-content">

            <div class="modal-header">
               <h5 class="modal-title" id="title">Editar tag</h5>
               <button type="button" class="close"  data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>

          <div class="modal-body">

                <div class="col-md-6 mb-3">
                       <label for="actividad">Nuevo nombre de tag</label>
                      <div class="input-group" id='frm_date_admission'>
                      <input type="text" class="form-control"  id="new_name_tag" >
                      <div class="invalid-feedback"></div>
                </div>  
                
          </div>


          <div class="form-group float-right">
                <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" id="btn_edit_tag" class="btn btn-primary">Editar</button>
              </div>
         </div> <!-- End card body archivos-->
         
</div>
</div>
</div>

<!----------------------------------------------------------------- modal update document-------------------------------------------------------------------------------------------------------->

<div class="modal fade bd-example-modal-lg" id="modal_edit_document" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
<div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="title">Editar tag</h5>
               <button type="button" class="close"  data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
      <div class="modal-body">
      <div class="card mb-3">
        <div class="card-body">


           <div class="row mb-2 " >
                <div class="col-md-6 mb-3">
                    <label for="actividad">Nombre del documento</label>
                      <div class="input-group" id='frm_date_admission'>
                          <input type="text" class="form-control" name="date_ap" id="doc_name_edit" >
                          <div class="invalid-feedback"></div>
                      </div>
                </div>

            </div>
            
            <div class="row mb-2 "  >
              <div class="col-md-2 mb-3"  >
                  <button type="button"  data-toggle="collapse" data-target="#tags_add_collapse" class="btn btn-primary">+ </button>
              </div>
           </div>
           <div class="row mb-2 collapse"  id="tags_add_collapse">
           <label class="ml-3"for="actividad">Agregar tags (seleccionar) :</label>
              <div class="col-md-12 mb-3 bg-light" id="tags_add_edit" ></div>
           </div>

           <div class="row mb-3 "  >
            <label class="ml-3"for="actividad">Tags actuales:</label>
               <div class="col-md-12 mb-3 ml-1 " id="tags_space_edit" >
               </div> 
           </div>

           <div class="row mb-2 mx-2 " id ="input_oc">
                <div class="col-md-6 mb-3 ">
                       <form id="ocse">
                       <div class= "custom-input" id= 'custom-file-create' >
                           <input type="file" class="custom-file-input" name="oce" id="oce" data-preview-file-type="any" accept="application/pdf" aria-describedby="inputGroupPrepend3">
                           <label class="custom-file-label " id='label-file-create' for="file">Elegir archivo</label>
                        </div>
                           
                       </form>
                 </div>
           </div>
          </div> <!-- card body-->
        </div> 
        
          <div class="form-group float-right">
                <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" id="btn_edit_document" class="btn btn-primary">Editar</button>
              </div>
         </div> <!-- End card body archivos-->
         
</div>
</div>
</div>


<script src="<?php echo base_url(); ?>assets/js_admin/adminLibrary.js"></script>
<script src="<?php echo base_url(); ?>assets/js_admin/editDocument.js"></script>

<!--ALTER TABLE `documentation` ADD FOREIGN KEY (`id_catdoc`) REFERENCES `category`(`id_cat`) ON DELETE RESTRICT ON UPDATE CASCADE; -->