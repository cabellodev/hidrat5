
<div id="content-wrapper">
  <div class="container-fluid mb-5">
    <div class="card mb-3">
      <div class="card-header">
            <ul class="nav nav-pills card-header-pills  ">
              <li class="nav-item ">
                  <a class="nav-link active" data-toggle="tab" href="#evaluacion">Evaluación</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#technicalReport">Informe Técnico</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link " data-toggle="tab" href="#aprobation">Aprobación</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link " data-toggle="tab" href="#reparation">Reparación</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link " data-toggle="tab" href="#hidraulicTest">Prueba Hidráulica</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link " data-toggle="tab" href="#historyStates">Historial de estados</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link " data-toggle="tab" href="#notesOrder">Notas</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link " data-toggle="tab" href="#images">Imágenes</a>
              </li>
            </ul>
      </div>

     <div class="card-body tab-content">

     <!-- Evaluations View and Edit -->
     <?php 
      require('evaluationEdit.php'); ?>
     <!-- Evaluations End -->

        <div class="table-responsive tab-pane fade" id="technicalReport">
            <?php require('technicalReportEdit.php'); ?> 
        </div>

        <div class="table-responsive tab-pane fade" id="reparation">
            <?php require('reparationEdit.php'); ?> 
        </div>

        <div class="table-responsive tab-pane fade" id="historyStates">
            <?php require('historyStates.php'); ?> 
        </div>
       
        
        <div class="table-responsive tab-pane fade" id="notesOrder">
            <?php require('notesOrder.php'); ?> 
        </div>
        <div class="table-responsive tab-pane fade" id="images">
            <?php  require('imagesAdmin.php'); ?> 
        </div>
    
    
    
       
     <?php require('aprobation.php');?>
    
     <?php require('hydraulicTestEdit.php');?>
    
   
    



    

     



</div><!--hidraulictest-->
</div><!--cotizacion-->
</div><!--aprobadas--> 

