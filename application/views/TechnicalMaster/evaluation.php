
<input type="hidden" class="form-control" id="ot_number" name="ot_number" value='<?= $id ?>' >
    <input type="hidden" class="form-control" id="id_ot" name="id_ot" value='<?= $id ?>' >
    <div id="content-wrapper">
    <div class="container-fluid mb-5" id="adminColors">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Evaluación</li>
            <li class="breadcrumb-item active">OT NÚMERO <?php echo $id; ?></li>
        </ol>
        <div class="card mb-3">
            <div class="card-header">
         </div>
        <div class="card">

        <div class="card-header" >
                 <button class="btn btn-link" data-toggle="collapse" data-target="#c2" aria-expanded="true" aria-controls="technicalReportGeneral">
                    <i class="fas fa-table"></i>
                    Evaluación
                   </button>
           </div>
         
        
         <div class="card-body collapse in show" id= "c2">
          
 <!-- evaluation-->

 <form>
    
    <input type="hidden" class="form-control" id="record_path_pdf" name="id" >
    <input type="hidden" class="form-control" id="name_technical" name="name_technical" >
        <input type="hidden" class="form-control" id="user_create_ev" name="id" >
        <input  type="hidden"  class="form-control" id="date_create_ev" name="id" >
        <input  type="hidden"  class="form-control" id="user_modify_ev" name="id" >
        <input  type="hidden"  class="form-control" id="date_modify_ev" name="id" >
        <input type="hidden"  class="form-control" id="user_approve_ev" name="id" >
        <input  type="hidden"  class="form-control" id="date_approve_ev" name="id" >
        <input type="hidden" class="form-control" id="technical_id" name="technical_id" >
        <input type="hidden" class="form-control" id="priority_ev" name="priority_ev" >
     
       
    <div class="row mb-2 ">
               
                <div class="col-md-3 mb-3 ">
                 
                      <div class="form-check">
                           <input class="form-check-input"   type="checkbox" id="approve_technical_ev" disabled>
                           <label class="form-check-label"  for="approve_technical_ev">
                            Aprobado por técnico master
                          </label>
                        </div>
                     </div>

                 
        </div>
        <div class="row mb-2">
              
              <div class="col-md-4 mb-3">
                  <label for="actividad">Fecha de evaluación</label>
                  <div class="input-group" id='frm_date_admission'>
                      <input type="text" class="form-control"  name="date_evaluation" id="date_evaluation" disabled>
                      <div class="invalid-feedback"></div>
                  </div>
              </div>
              <div class="col-md-4 mb-3">
                  <label>Ubicación</label>
                  <select class="custom-select d-block w-100" id="location_ev" name="location_ev" disabled>
                      <option></option>
                  </select>
                  <div class="invalid-feedback"></div>
              </div>
              
          </div>
          <div class="row mb-2">          
              <div class="col-md-12 mb-3">
                  <label for="actividad">Problema</label>
                  <div class="input-group" id='frm_date_admission'>
                      <input type="text" class="form-control"  name="problem" id="problem" disabled>
                      <div class="invalid-feedback"></div>
                  </div>
              </div>
          </div>
          <div class="row mb-2">
              <div class="col-md-12 mb-3">
                  <label for="actividad">Descripción</label>
                    <div class="input-group">
                      <textarea type="text" class="form-control"  rows="2" name="description_ev" id="description_ev" placeholder="" aria-describedby="inputGroupPrepend3" disabled></textarea>
                        <div class="invalid-feedback descripcion" style="display: none;  color:red">
                                Ingrese una descripción porfavor.
                        </div>
                      </div>
              </div>  
          </div>
          <div class="row mb-2">
              <div class="col-md-12 mb-3">
                  <label for="actividad">Notas</label>
                    <div class="input-group">
                      <textarea type="text" class="form-control"  rows="2" name="notes" id="notes" placeholder="" aria-describedby="inputGroupPrepend3" disabled></textarea>
                        <div class="invalid-feedback descripcion" style="display: none;  color:red">
                                Ingrese una descripción porfavor.
                        </div>
                  </div>
              </div>  
          </div>
          
      
          <div class="form-group" style="margin-top: 40px; float:right;">
              <button class="btn btn-success" value='0' type='button' id="hab_edit_ev"><i id='tr_i_btnEdit' class="fas fa-edit" style="margin-right: 5px;"></i>Editar</button>
              <button class="btn btn-success" style='display:none' type='button' id="btn_edit"><i class="fas fa-save" style="margin-right: 5px;"></i>Guardar Cambios</button>
          </div>
          </form>
          </div> 
          </div> 
    </div> 
  </div> <!-- content-wrapper-->
  </div> 

    <script src="<?php echo base_url(); ?>assets/js_admin/technical_master/evaluationForm.js"></script>
  
