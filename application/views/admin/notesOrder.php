<!-- formulario de vista de evaluación para superadmin -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/comment.js/jquery-comments.css">
<div id='reparation_info'>
    <div class="card">
        <div class="card-header" id="headingTR">
            <h5 class="mb-0">
            <button class="btn btn-link" data-toggle="collapse" data-target="#notes_order" aria-expanded="false" aria-controls="notes_order">
                <i class="fas fa-table"></i>
                Historial de notas
            </button>
            </h5>
        </div>
        <div id="notes_order" class="collapse show" aria-labelledby="headingTR">
            <div class="card-body">
                <div id="notes-container"></div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/vendor/comment.js/jquery-comments.js"></script>
<script src="<?php echo base_url(); ?>assets/js_admin/notesOrder.js"></script>




