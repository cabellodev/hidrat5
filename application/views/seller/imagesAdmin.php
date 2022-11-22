
<div id="imagesAdmin">
      <div class="card mb-3">
       <div class="card-header">
        <i class="fas fa-table"></i>
        Lista de Imágenes
      </div> <!-- end card header ---->
      <div class="card-body">
           <div class="row">
               <div class="col-sm">
                   <p id="UserModalInfo"></p>
               </div>
           </div> <!-- end row ---->
      
           <div class="form-group">
              <form  id= "foto" >
                 <div class="row">
               
                          <div class="col-md-4 mb-3 ml-2">
          <!--  id_imagen --><input type="hidden" class="form-control" id="id_imagen" name="id" value='<?= $id ?>' >
                             <div class="form-group" id="frm_foto">
                                  <div class= "custom-input" id= 'custom-file-create' >
                                    <input type="file" class="custom-file-input" data-preview-file-type="any" name="file[]" id="file" multiple>
                                    <label class="custom-file-label " id='label-file-create' for="file">Elegir imágenes</label>
                                  </div>
                                   <label id='auxiliar' ></label>
                              </div>
                        </div>
              
                         <div class="col-md-6 "> 
                          <button type="button" id="addImage" class="btn btn-primary">Guardar</button>
                         </div>
                 </div>
               </form>
            </div> <!-- end form-group -->
              <!-- end card body  -->


         <div class="table-responsive">
          <table class="table table-bordered" id="t_images" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Name</th>
                <th>Imagen</th>
                <th>Ver</th>
                <th>Editar</th>
                <th>Eliminar</th>
              </tr>
            </thead>
          </table>
         </div><!-- end table-responsive--->

      </div> <!-- endcar-->
</div>
</div>
  
<div class="modal fade" id="show_image" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">              
      <div class="modal-body" >
      	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <img src="" class="imagepreview  " style="width: 100%;" >
      </div>
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-lg" id="editImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
           <div class="modal-header">
              <h5 class="modal-title" id="title">Editar Imagen</h5>
              <button type="button" class="close"  data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
           </div>

         <div class="modal-body">
              <div class="row">
                    <div class="col-sm">
                        <p id="UserModalInfo"></p>
                    </div>
              </div>
      
         <div class="form-group">
                  <form  id= "foto_e" >
                         <div class="row">
                               <div class="col-md-6 mb-3">
                                      <label for="actividad">Nombre de la imagen</label>
                                            <div div class="input-group" id="frm_name2">
                                                <input type="text" class="form-control"  name="name" id="name_e" placeholder="Ingrese nombre">
                                                <div class="invalid-feedback "></div>
                                            </div>
                               </div>
                         </div>

                          <div class="row">
                                  <div class="col-md-12 mb-3">
         <!--id_e-->              <input type="hidden" class="form-control" id="id_e" name="id_e" value='<?= $id ?>' >
                                         <label for="actividad">Cargar imagen:</label>
                                         <div class="form-group " id="frm_foto">
                                             <div class= "custom-input" >
                                                 <input type="file" class="custom-file-input" data-preview-file-type="any" name="file" id="file_e">
                                                  <label class="custom-file-label" for="file_e">Elegir imagen</label>
                                             </div>
                                        </div>
    <                              </div>
                      
                                  <div class="form-group float-right">
                                      <button type="button" id="editButton" class="btn btn-primary">Guardar</button>
                                   </div>
                           </div>
                      </form>
         </div>
         </div> 
  </div>
</div>
</div>

<script src="<?php echo base_url(); ?>assets/js_admin/seller/imagenAdmin.js"></script>
