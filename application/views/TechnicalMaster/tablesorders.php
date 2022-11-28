
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
                  <a class="nav-link " data-toggle="tab" href="#reparation">Reparación</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link " data-toggle="tab" href="#hidraulicTest">Prueba Hidráulica</a>
              </li>
           
             
            
            </ul>
      </div>

     <div class="card-body tab-content">

     <!-- Evaluations View and Edit -->
     <?php 
      require('ev_details.php'); ?>
     <!-- Evaluations End -->


        <div class="table-responsive tab-pane fade" id="technicalReport">
            <?php require('tr_details.php'); ?> 
        </div>

        <div class="table-responsive tab-pane fade" id="reparation">
            <?php require('rep_details.php'); ?> 
        </div>

       

       
     <?php require('ht_details.php');?>
     





    

     



</div><!--hidraulictest-->
</div><!--cotizacion-->
</div><!--aprobadas--> 

