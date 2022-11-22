<div id="content-wrapper">
    <div class="container-fluid mb-5" id="adminColors">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Órdenes de trabajo</li>
            <li class="breadcrumb-item active">Editar OT</li>
        </ol>

        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-table"></i>
                Información general 
            </div>

            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-4 mb-3">
                        <label for="actividad">Numero de OT</label>
                        <div class="input-group" id='frm_ot_number'>
                            <input type="text" class="form-control" name="ot_number" id="ot_number" value="<?= $number_ot ?>" aria-describedby="inputGroupPrepend3">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3" id='frm_enterprise'>
                        <label>Empresa</label>
                        <select class="custom-select d-block w-100" name="enterprise" id="enterprise">
                            <?php foreach($enterprises as $item) { 
                            if($enterprise == $item['name']){
                            ?>
                                <option value='<?= $item['id'] ?>' selected="true" name='<?= $item['name'] ?>'><?= $item['name'] ?></option>
                            <?php }else{ ?>  
                                <option value='<?= $item['id'] ?>' name='<?= $item['name'] ?>'><?= $item['name'] ?></option>
                            <?php }} ?>  
                        </select>  
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-4 mb-3" id="frm_service">
                        <label>Tipo Servicio</label>
                        <select class="custom-select d-block w-100" id="service" name="service" required="">
                            <?php if($service == "Reparación"){?>
                                    <option value="Reparación" selected="true">Reparación</option>
                                    <option value="Fabricación">Fabricación</option>
                                    <option value="Mantención">Mantención</option>
                            <?php } ?>  
                            <?php if($service == "Fabricación"){?>
                                <option value="Reparación">Reparación</option>
                                <option value="Fabricación" selected="true">Fabricación</option>
                                <option value="Mantención">Mantención</option>
                            <?php } ?>  
                            <?php if($service == "Mantención"){?>
                                <option value="Reparación">Reparación</option>
                                <option value="Fabricación">Fabricación</option>
                                <option value="Mantención" selected="true">Mantención</option>
                            <?php } ?>  
                        </select>
                        <div class="invalid-feedback"></div>
                    </div> 
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-3" id='frm_component'>
                        <label>Componente</label>
                        <select class="custom-select d-block w-100" name="component" id="component">
                            <?php foreach($components as $item) { 
                            if($component == $item['name']){
                            ?>
                                <option value='<?= $item['id'] ?>' selected="true" name='<?= $item['name'] ?>'><?= $item['name'] ?></option>
                            <?php }else{ ?>  
                                <option value='<?= $item['id'] ?>' name='<?= $item['name'] ?>'><?= $item['name'] ?></option>
                            <?php }} ?>  
                        </select>  
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-4 mb-3" id="frm_priority">
                        <label>Prioridad</label>
                        <select class="custom-select d-block w-100" id="priority" name="priority" required="">
                            <?php if($priority == "Baja"){?>
                                    <option value="Baja" selected="true">BAJA</option>
                                    <option value="Media">MEDIA</option>
                                    <option value="Alta">ALTA</option>
                            <?php } ?>  
                            <?php if($priority == "Media"){?>
                                    <option value="Baja">BAJA</option>
                                    <option value="Media" selected="true">MEDIA</option>
                                    <option value="Alta">ALTA</option>
                            <?php } ?>  
                            <?php if($priority == "Alta"){?>
                                    <option value="Baja">BAJA</option>
                                    <option value="Media">MEDIA</option>
                                    <option value="Alta" selected="true">ALTA</option>
                            <?php } ?>  
                        </select>
                        <div class="invalid-feedback"></div>
                    </div> 
                    <div class="col-md-4 mb-3" id='frm_location'>
                        <label>Ubicación</label>
                        <select class="custom-select d-block w-100" name="location" id="location">
                            <?php if($location != null) {?>
                                <option></option>
                                <?php foreach($locations as $item) { 
                                if($location == $item['name']){
                                ?>
                                    <option value='<?= $item['id'] ?>' selected="true" name='<?= $item['name'] ?>'><?= $item['name'] ?></option>
                                <?php }else{ ?>  
                                    <option value='<?= $item['id'] ?>' name='<?= $item['name'] ?>'><?= $item['name'] ?></option>
                                <?php }} ?>  
                            <?php } else {?>
                                <option></option>
                                <?php foreach($locations as $item) { ?>
                                    <option value='<?= $item['id'] ?>' name='<?= $item['name'] ?>'><?= $item['name'] ?></option>
                                <?php } ?>  
                            <?php }?>
                        </select>   
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12 mb-3">
                        <label for="actividad">Descripción</label>
                        <div class="input-group">
                            <textarea type="text" class="form-control" rows="2" name="description" id="description" placeholder="" aria-describedby="inputGroupPrepend3"><?= $description ?></textarea>
                            <div class="invalid-feedback descripcion" style="display: none;  color:red">
                                Ingrese una descripción porfavor.
                            </div>
                        </div>
                    </div>  
                </div>
                <div class="row mb-2">
                    <div class="col-md-12 mb-3">
                        <label for="actividad">Problema</label>
                        <div class="input-group">
                            <textarea type="text" class="form-control" rows="2" name="problem" id="problem" placeholder="" aria-describedby="inputGroupPrepend3"><?= $problem ?></textarea>
                            <div class="invalid-feedback descripcion" style="display: none;  color:red">
                                Ingrese una descripción porfavor.
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-table"></i>
               Información de ingreso
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-4 mb-3">
                        <label for="actividad">Fecha de ingreso</label>
                        <div class="input-group" id="frm_date_admission">
                            <input type="text" class="form-control" value="<?= $date ?>" name="date_admission" id="date_admission" placeholder="" aria-describedby="inputGroupPrepend3">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                    <label for="actividad">Dias para cotización</label>
                        <div class="input-group" id="frm_days_quotation">
                            <input type="number" min="0" class="form-control" value="<?= $days_quote?>" name="days_quotation" id="days_quotation" placeholder="" aria-describedby="inputGroupPrepend3">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div> 
                </div>   
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-table"></i>
               Configuración
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-4 mb-3">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="check_evaluation" 
                            <?php if($config['evaluation'] == 'true') { ?>checked<?php }else{} ?>>
                            <label class="custom-control-label" for="check_evaluation">Evaluación</label>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="check_report_technical"
                            <?php if($config['technical_report'] == 'true') { ?>checked<?php }else{} ?>>
                            <label class="custom-control-label" for="check_report_technical">Informe Técnico</label>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="check_hydraulic_test"
                            <?php if($config['hydraulic_test'] == 'true') { ?>checked<?php }else{} ?>>
                            <label class="custom-control-label" for="check_hydraulic_test">Prueba Hidráulica</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="margin-right: 40px; margin-bottom: 40px;">
                <button style="float: right" class="btn btn-success" type='button' id="btnUpdate">Guardar Cambios</button>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js_admin/updateOrder.js"></script>
<script>
  $( function() {
    $( "#date_admission" ).datepicker({
        showOn: "button",
        buttonText: "Calendario",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        buttonImage: host_url + 'assets/img/about/calendario2.png',
    });
  } );
  $( function() {
    $( "#date_provider_number" ).datepicker({
        showOn: "button",
        buttonText: "Calendario",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        buttonImage: host_url + 'assets/img/about/calendario2.png',
    });
  } );
  </script>

