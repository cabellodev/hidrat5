
<!-- formulario de vista de evaluación para superadmin -->

<div class="table-responsive tab-pane fade show active " id="evaluacion" >
      <div role="alert" id="alert_evaluation">
          <strong id="title_alert_ev"></strong>
        </div>
      <div id="accordion">
      <div id="evaluation_info" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
        <div class="card-body">

        <input type="hidden" class="form-control" id="record_path_pdf" name="id" >
        <input type="hidden" class="form-control" id="name_technical" name="id" >
        <input type="hidden" class="form-control" id="user_create_ev" name="id" >
        <input type="hidden" class="form-control" id="date_create_ev" name="id" >
        <input type="hidden" class="form-control" id="user_modify_ev" name="id" >
        <input type="hidden" class="form-control" id="date_modify_ev" name="id" >
        <input type="hidden" class="form-control" id="user_approve_ev" name="id" >
        <input type="hidden" class="form-control" id="date_approve_ev" name="id" >
      

        <div class="row mb-2 mr-2 justify-content-end">
        <a  id="ev_popover" data-toggle="popover" data-placement="left"><i class=" fas fa-info-circle fa-lg"></i></a>  
        </div>
        
        <div class="row mb-2 ">
                <div class="col-md-3 mb-3 ">
                 
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
                     </div>
        </div>
        <div class="row mb-2">
              <div class="col-md-4 mb-3">
                  <label for="actividad">Número de OT</label>
                  <div class="input-group" id='frm_ot_number'>
                      <input type="text" class="form-control" name="id_ot" id="id_ot" value='<?= $number_ot ?>' readonly>
                      <div class="invalid-feedback"></div>
                  </div>
              </div>
              <div class="col-md-4 mb-3">
                  <label for="actividad">Fecha de evaluación</label>
                  <div class="input-group" id='frm_date_admission'>
                      <input type="text" class="form-control" name="date_evaluation" id="date_evaluation"  readonly>
                      <div class="invalid-feedback"></div>
                  </div>
              </div>
          </div>
          <div class="row mb-2">
              <div class="col-md-6 mb-3">
                  <label for="actividad">Descripción</label>
                    <div class="input-group">
                      <textarea type="text" class="form-control" rows="2" name="description_ev" id="description_ev" placeholder="" aria-describedby="inputGroupPrepend3" readonly></textarea>
                        <div class="invalid-feedback descripcion" style="display: none;  color:red">
                                Ingrese una descripción porfavor.
                        </div>
                      </div>
              </div>  
              <div class="col-md-6 mb-3">
                  <label for="actividad">Notas</label>
                    <div class="input-group">
                      <textarea type="text" class="form-control" rows="2" name="notes" id="notes" placeholder="" aria-describedby="inputGroupPrepend3" readonly></textarea>
                        <div class="invalid-feedback descripcion" style="display: none;  color:red">
                                Ingrese una descripción porfavor.
                        </div>
                  </div>
              </div>  
          </div>

          <div class="row mb-2">
               <div class="col-md-4 mb-3">
                  <label for="actividad">Técnico asignado para evaluación</label>
                  <div class="input-group" id='frm_priority'>
                      <input type="text" class="form-control" name="technical" id="technical"  readonly>
                      <div class="invalid-feedback"></div>
                  </div>
              </div> 
          </div>
   </div>
      
    </div> 
    </div>
    </div> <!-- End content Evaluation-->
    <script src="<?php echo base_url(); ?>assets/js_admin/evaluation.js"></script>