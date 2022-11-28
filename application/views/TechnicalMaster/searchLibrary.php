<div id="content-wrapper">
  <div class="container-fluid mb-5">

    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Búsqueda de documentación</li>
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
          En esta sección podra encontrar todos los documentos activos acerca de diferentes temas para contribuir al desarrollo de trabajos de componentes.
          </div>
        </div>
      </div>
    </div>



    <div class="card mb-3">
      <div class="card-header">
        <i class="fas fa-edit"></i>
        Ingreso de búsqueda
      </div>
      <div class="card-body">

       <!--
           <div class="row mb-3 " >
                <div class="col-md-6 mb-3">
                    <label for="actividad">Nombre del documento</label>
                      <div class="input-group" id='frm_date_admission'>
                          <input type="text" class="form-control" name="date_ap" id="doc_name" >
                          <div class="invalid-feedback"></div>
                      </div>
                </div>

                <div class="col-md-6 mb-3">
                      <label for="actividad">Correlativo(alfanumérico)</label>
                           <div class="input-group" id='frm_date_admission'>
                              <input type="text" class="form-control" name="date_ap" id="doc_correlative" >
                                <div class="invalid-feedback"></div>
                          </div>
                </div>
              
            </div>
-->
            <label for="actividad">Seleccione tags de temas de su interes:</label>
            <div class="row my-3"  >
                
               <div class="col-md-10 mb-3 " id="tags_search" > </div> 
           </div>

            <div style="margin-right: 40px; margin-bottom: 40px;">
                  <button type="button" id="btn_search_doc" class="btn btn-success float-right ">Buscar</button>
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
                          </tr>
                       </thead>
                  </table>
              </div>
          </div>
        </div>
        <div class="alert alert-info" id="alert-active" > No tienes los privilegios necesarios para manipular esta sección. Comunicate con el super administrador.</div>
     </section>
  </div>
</div>

<script src="<?php echo base_url(); ?>assets/js_admin/technical_master/searchLibrary.js"></script>