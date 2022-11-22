<div class="table-responsive tab-pane fade show active " id="evaluacion" >
      <div role="alert" id="alert_evaluation">
          <strong id="title_alert_ev"></strong>
        </div>
      <div id="accordion">
      <div id="evaluation_info" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
        <div class="card-body">
    <form>
    
    <input type="hidden" class="form-control" id="record_path_pdf" name="id" >
    <input type="hidden" class="form-control" id="name_technical" name="name_technical" >
        <input type="hidden" class="form-control" id="user_create_ev" name="id" >
        <input  type="hidden"  class="form-control" id="date_create_ev" name="id" >
        <input  type="hidden"  class="form-control" id="user_modify_ev" name="id" >
        <input  type="hidden"  class="form-control" id="date_modify_ev" name="id" >
        <input type="hidden"  class="form-control" id="user_approve_ev" name="id" >
        <input  type="hidden"  class="form-control" id="date_approve_ev" name="id" >
      



        <div class="row mb-2 ">
       <!--     <div class="col-md-3 mb-3 ">
                <div class="form-check">
                  <input class="form-check-input" style="background:white"  type="checkbox"  id="approve_admin_ev" disabled>
                  <label class="form-check-label"  for="approve_admin_ev">
                    Aprobado por administración
                  </label>
                </div>
            </div>
            <div class="col-md-3 mb-3 ">
                <div class="form-check">
                      <input class="form-check-input"  style="background:white" type="checkbox" id="approve_technical_ev" disabled>
                      <label class="form-check-label"  for="approve_technical_ev">
                      Aprobado por técnico master
                    </label>
                </div>
            </div>-->
            <div class="col-md-12 mb-3" style='text-align: right;'>
                <button id="btn_export_ev" style='display: none;' type="button" class="btn btn-primary rounded-circle" data-toggle="popover" data-placement="left"><i class="fas fa-file-export"></i></i></button>
                <button id="ev_popover" type="button" class="btn btn-primary rounded-circle" data-toggle="popover" data-placement="left"><i class="fas fa-info"></i></button>
            </div>  
        </div>
        <div class="row mb-2">
              <div class="col-md-4 mb-3">
                  <label for="actividad">Número de OT</label>
                  <div class="input-group" id='frm_ot_number'>
                      <input type="text" class="form-control"  name="id_ot" id="id_ot"  value='<?= $number_ot ?>'  disabled>
                      <div class="invalid-feedback"></div>
                  </div>
              </div>
              <div class="col-md-4 mb-3">
                  <label for="actividad">Fecha de evaluación</label>
                  <div class="input-group" id='frm_date_admission'>
                      <input type="text" class="form-control"  name="date_evaluation" id="date_evaluation" disabled>
                      <div class="invalid-feedback"></div>
                  </div>
              </div>
              <!-- <div class="col-md-4 mb-3" id="frm_location">
                        <label>Ubicación</label>
                        <select class="form-select form-control" id="location_ev" name="location_ev" disabled>
                            <option></option>
                        </select>
                    </div> -->
          </div>
          <div class="row mb-2">
              <div class="col-md-6 mb-3">
                  <label for="actividad">Descripción</label>
                    <div class="input-group">
                      <textarea type="text" class="form-control"  rows="2" name="description_ev" id="description_ev" placeholder="" aria-describedby="inputGroupPrepend3" disabled></textarea>
                        <div class="invalid-feedback descripcion" style="display: none;  color:red">
                                Ingrese una descripción porfavor.
                        </div>
                      </div>
              </div>  
              <div class="col-md-6 mb-3">
                  <label for="actividad">Notas</label>
                    <div class="input-group">
                      <textarea type="text" class="form-control"  rows="2" name="notes" id="notes" placeholder="" aria-describedby="inputGroupPrepend3" disabled></textarea>
                        <div class="invalid-feedback descripcion" style="display: none;  color:red">
                                Ingrese una descripción porfavor.
                        </div>
                  </div>
              </div>  
          </div>

          <div class="row mb-2">
               <div class="col-md-4 mb-3">
               <label>Asignar técnico para la evaluación</label>
                <select class="form-select form-control"  id="technical_ev" name="technical_ev" disabled>
                <option></option>
              </select>
                <div class="invalid-feedback"></div>
              </div> 
              <div class="col-md-4 mb-3" >
                        <label for="actividad">Tipo de prioridad</label>
                        <select class="form-select form-control"  id="priority_ev" name="priority_ev" required="" disabled>
                            <option></option>
                            <option value="1">BAJA</option>
                            <option value="2">MEDIA</option>
                            <option value="3">ALTA</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div> 
                    
          </div>
 <!--         <div class="form-group" style="margin-top: 40px; float:right;">
              <button class="btn btn-success" value='0' type='button' id="hab_edit_ev"><i id='tr_i_btnEdit' class="fas fa-edit" style="margin-right: 5px;"></i>Editar</button>
              <button class="btn btn-success" style='display:none' type='button' id="btn_edit"><i class="fas fa-save" style="margin-right: 5px;"></i>Guardar Cambios</button>
          </div>-->

          
           <!--  <div class="row mb-2 mr-2 mb-5 justify-content-end">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="hab_edit_ev" >
                  <label class="form-check-label" for="approve_ht">
                    Activar edición 
                  </label>
                </div>
            </div> -->
          </form>
   </div><!-- card body end-->
      
    </div> <!-- card body end-->
    </div><!-- acordion-->
    </div> <!-- End content Evaluation-->

    <script src="<?php echo base_url(); ?>assets/js_admin/seller/evaluation.js"></script>
  

