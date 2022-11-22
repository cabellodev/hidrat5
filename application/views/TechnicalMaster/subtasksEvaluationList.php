<div id="content-wrapper">
    <div class="container-fluid mb-5">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Subtareas de evaluaciones, OT: <?= $id ?></li>
            <input value=<?= $id ?>  name="ot_id" id="ot_id" style='display:none'>
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
                        En esta sección se podrá realizar la elaboración de las subtareas de evaluaciones de las OT que han sido ingresadas por sistema , ademas de su respectiva aprobación por parte de técnico master.
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-table"></i>
                Lista de subtareas
                <button class="btn btn-success float-right" type='button' data-toggle="modal" id='btn_create_substak' data-target="#modalSubstaks"><i class="fas fa-plus"></i> Crear subtarea</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="tableSubstaksEvaluations" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>N° de OT </th>
                            <th>Id </th>
                            <th>Fecha</th>
                            <th>Subtarea</th>
                            <th>Ayudante Técnico</th>
                            <th>Realizado por ayudante técnico</th>
                            <th>Aprobado por técnico master</th>
                            <th>Estado </th>
                            <th>Ver detalles </th>
                            <th>Acción</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalSubstaks" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitlewrwerwr" >
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo">Crear Subtarea</h5>
                <button  type="button" class="close" onclick="close_modal()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-md-6 mb-3" id="frm_substak">
                        <label>Subtarea</label>
                        <select class="custom-select d-block w-100" id="substak" name="substak">
                            <option></option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-6 mb-3" id="frm_technical_assistant">
                        <label>Ayudante Técnico</label>
                        <select class="custom-select d-block w-100" id="technical_assistant" name="technical_assistant">
                            <option></option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-3 ">
                        <label for="actividad">Fecha de ingreso</label>
                        <div class="input-group" id="frm_date_admission">
                            <input type="text" class="form-control" name="date_admission" id="date_admission" placeholder="" aria-describedby="inputGroupPrepend3">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3 mb-3" id="frm_check_tm" style='display:none'>
                        <div class="form-check">
                            <input class="form-check-input"  type="checkbox" value="" id="tr_check_technical_master">
                            <label class="form-check-label"  for="tr_check_technical_master">
                                Aprobado por técnico master
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3" id="frm_check_at" style='display:none'>
                        <div class="form-check">
                                <input class="form-check-input"  type="checkbox" value="" id="tr_check_technical_assistant">
                                <label class="form-check-label"  for="tr_check_technical_assistant">
                                Aprobado por ayudante técnico
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group float-right">
                    <button onclick="close_modal()" type="button" class="btn btn-secondary btn-danger">Cerrar</button>
                    <button id="btn_ok" type="button" class="btn btn-primary btn-success">Crear subtarea</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js_admin/technical_master/subtasksEvaluation.js"></script>
<script>
  $( function() {
    $( "#date_admission").datepicker({
        showOn: "button",
        buttonText: "Calendario",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        buttonImage: host_url + 'assets/img/about/calendario2.png',
    });
  } );
</script>