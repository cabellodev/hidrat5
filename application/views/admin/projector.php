<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="hidratec-admin">
      <meta name="author" content="asdad ">

      <title>Administración Sistema Hidratec</title>

      <!-- Custom fonts for this template-->
    
      <link href="<?php echo base_url(); ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
      <link href="<?php echo base_url(); ?>assets/vendor/DataTables/datatables.min.css" rel="stylesheet" type="text/css" />

      <link href="<?php echo base_url(); ?>assets/css_admin/sb-admin-2.min.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>assets/vendor/DataTables/fixedHeader.dataTables.min.css" rel="stylesheet" type="text/css" />
    
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/3.1.2/fullpage.css"  /> 
      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
      <link href="<?php echo base_url(); ?>assets/vendor/jquery-ui-1.12.1.custom/jquery-ui.css" type="text/css" rel="stylesheet"/>
      <script>
      const host_url = "<?php echo base_url(); ?>";

      
    </script>
    <style>
      .conteiner-production .conteiner-title{
        margin-top:20px;
        text-align: center;
        position: relative;
      }

      .header  {
        text-align: center;
        position: relative;
        color:white;
      }

      #chart_quotation { 
        width :fit-content;
        margin: 0 auto;
      }

      #chart_production {
        
        width :fit-content;
        margin: 0 auto;
        
      }
      .section{
          text-align: center;
        position: relative;
        color:white;
      }

      #fp-nav ul li a span{
          background: white;
      }

      .footer {
          text-align: center;
        position: relative;
        color: black;
      }
    </style>
  </head>
  <body>
    <main id="fullpage">
      <header class="section header active">
        <h1><span class="title-quotation" >Indicador de cotizaciones</span> <i class="fas fa-sign-out-alt btn_exit"></i></h1>  
        <div  id="chart_quotation"></div>
      </header>
      <header class="section ">
        <h1 > <span class="title-production">Indicador de producción</span> <i class="fas fa-sign-out-alt btn_exit"></i></h1>
        <div   id="chart_production"></div>  
      </header>

      <footer class="section footer">  
        <h1><span class="title-work">Seguimiento trabajo </span> <i class="fas fa-sign-out-alt btn_exit"></i> </h1>
          <div class="card-body">
            <div class="table-responsive ">
              <table class="table table-bordered" id="table-work" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>OT</th>
                    <th>Cliente</th>
                    <th>Descrip.</th>
                    <th>Prioridad</th>
                    <th>Dias rep </th>
                    <th>Caduca</th>
                    <th>Asignado</th>
                    <th>Estado</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
      </footer> 

      
      <footer class="section footer">  
        <h1><span class="title-work">Seguimiento evaluaciones </span> <i class="fas fa-sign-out-alt btn_exit"></i> </h1>
          <div class="card-body">
            <div class="table-responsive ">
              <table class="table table-bordered" id="table-quotation" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>OT</th>
                    <th>Cliente</th>
                    <th>Descrip.</th>
                    <th>Prioridad</th>
                    <th>Dias Cot </th>
			    <th>Caduca</th>
			    <th>Asignado</th>
                    <th>Estado</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
      </footer> 

    </main>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/3.1.2/fullpage.js" ></script>
    <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
      
    <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    
      
    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/DataTables/datatables.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url(); ?>assets/js_admin/sb-admin-2.min.js"></script>


    <script src="<?php echo base_url(); ?>assets/vendor/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/lodash/lodash.js"></script>
    <script src="<?php echo base_url(); ?>assets/js_admin/projector.js"></script>
    <script src="<?php echo base_url(); ?>assets/js_admin/proyectorTable.js"></script>
  </body>
</html>

