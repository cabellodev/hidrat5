<div id="content-wrapper">
  <div class="container-fluid mb-5">

    <ol class="breadcrumb">
      <li class="breadcrumb-item active" id="header-title">Administración de Imagenes / OT NÚMERO <?php echo $id; ?></li>
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
           En esta sección podra realizar la carga de imágenes para la OT seleccionada .
          </div>
        </div>
      </div>
    </div>
    
    <div class="card mb-3">
      <div class="card-header">
        <i class="fas fa-table"></i>
        Lista de Imágenes
      </div>
      <div class="card-body">
      <div class="row">
          <div class="col-sm">
            <p id="UserModalInfo"></p>
          </div>
        </div>
      
        <div class="form-group">
        <form  id= "foto" >
              <div class="row">
               
                   <div class="col-md-4 mb-3 ml-2">
                      <input type="hidden" class="form-control" id="id" name="id" value='<?= $id ?>' >
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
                    </form>
               </div>
               </div>


      <div class="table-responsive">
          <table class="table table-bordered" id="table_images" width="100%" cellspacing="0">
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
        </div>
      </div>
    </div>
    <div class="row mb-3"></div>
  </div>
</div>





<!---   modal image ---->
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


<!---   modal edit image  ---->
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
                      <input type="hidden" class="form-control" id="id_e" name="id_e" value='<?= $id ?>' >
                      
                 
                      <label for="actividad">Cargar imagen:</label>
                      <div class="form-group " id="frm_foto">
                       <div class= "custom-input" >
                          <input type="file" class="custom-file-input" data-preview-file-type="any" name="file" id="file_e">
                          <label class="custom-file-label" for="file_e">Elegir imagen</label>
                          </form>
                          </div>
                      </div>
                   <div class="form-group float-right">
                       <button type="button" id="editButton" class="btn btn-primary">Guardar</button>
                  </div>
                </div>
  
        </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url(); ?>assets/js_admin/adminImages.js"></script>
<script src="<?php echo base_url(); ?>assets/js_admin/editImagen.js"></script>