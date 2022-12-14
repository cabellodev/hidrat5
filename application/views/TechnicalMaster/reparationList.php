<div id="content-wrapper">
    <div class="container-fluid mb-5">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Reparaciones</li>
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
                        En esta sección se podrá realizar la elaboración de los informes técnicos de las OT que han sido ingresadas por sistema , ademas de su respectiva aprobación por parte de técnico master.
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-table"></i>
                Lista de reparaciones
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="tableReparations" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>N° de OT </th>
			                <th>Fecha de asignación</th>
			                <th>Fecha Límite</th>
                            <th>Cliente</th> 
                            <th>Descripción</th>
                            <th>Prioridad</th>
                            <th>Tipo de servicio</th>
                            <th>Estado</th>
                            <th>Aprobado por administración</th>
                            <th>Acción</th>
                            <th>Subtareas</th>
                            <th>Imágenes</th>
                            <th>Reparación</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js_admin/technical_master/reparationList.js"></script>






