<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title> Visualizar documento</title>
</head>
<link href="<?php echo base_url(); ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url(); ?>assets/css_admin/sb-admin-2.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/vendor/DataTables/datatables.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/vendor/DataTables/fixedHeader.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/vendor/jquery-ui-1.12.1.custom/jquery-ui.css" type="text/css" rel="stylesheet"/>
    <script>
    const host_url = "<?php echo base_url(); ?>";
    </script>

<body>
<style>#canvas_container {width: 800px;height: 400px;}</style>


<div id="content-wrapper">
      
<input type ="hidden" id="file" value='<?= $name ?>'/>
  <div class="container-fluid mb-5">
  <div class="row" ></div>
        <div id="navigation_controls">
              <button id="go_previous">Previous</button>
              <input id="current_page" value="1" type="number"/>
              <button id="go_next">Next</button>
        </div>
        <span></span>
        <div id="zoom_controls">  
              <button id="zoom_in">+</button>
              <button id="zoom_out">-</button>
        </div>
      <div id="my_pdf_viewer">
        <div id="canvas_container">
              <canvas id="pdf_renderer"></canvas>
        </div>
        
     </div>
  </div>
</div>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.943/pdf.min.js">
</script>
<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/canvas/html2canvas.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/DataTables/datatables.min.js"></script>
  
    <script src="<?php echo base_url(); ?>assets/sweetalert.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js_admin/viewer_pdf.js"></script>
    <script src="<?php echo base_url(); ?>assets/js_admin/sb-admin-2.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js_admin/menu.js"></script>

    <script src="<?php echo base_url(); ?>assets/vendor/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/lodash/lodash.js"></script>
    
      
</body>
</html>

