<!-- formulario de vista de evaluación para superadmin -->
<div id='reparation_info'>
    <div class="card">
        <div class="card-header" id="headingTR">
            <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#history_states" aria-expanded="false" aria-controls="technicalReportGeneral">
                <i class="fas fa-table"></i>
                Historial de estados
            </button>
            </h5>
        </div>
        <div id="history_states" class="collapse show" aria-labelledby="headingTR">
            <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table_history_states" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Estado</th>
                        <th>Fecha de actualización </th>
                        <th>Usuario resposable</th>
                    </tr>
                    </thead>
                </table>
            </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js_admin/historyStates.js"></script>
