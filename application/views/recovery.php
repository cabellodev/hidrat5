<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title> Login </title>
  <link rel="icon" type="image/png" href="<?php echo base_url(); ?>/assets/img/logos/logo_size.jpg" />
  <link href="<?php echo base_url(); ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
  
  <link href="<?php echo base_url(); ?>/assets/css/login.css" rel="stylesheet" />
</head>


<style type="text/css">
  .chargePage {
    display: none;
    position: fixed;
    z-index: 10000;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    background: rgba(255, 255, 255, .8) url('<?php echo base_url(); ?>assets/img/loading.svg') 50% 50% no-repeat
  }

  body.loading .chargePage {
    overflow: hidden;
    display: block
  }

  .box {
    margin-top: 50px;
    padding: 15px
  }
</style>
<body>
<div class="chargePage"></div>
<div class="container px-4 py-5 mx-auto">
    <div class="card card1 mx-auto">
        <div class="row justify-content-center my-auto">
            <div class="col-md-8 col-10">
                <div class="row justify-content-center"> <img id="logo" src="<?php echo base_url(); ?>assets/img/logos/logo_hidratec.jpg"> </div>
                <h6 class="msg-info text-center" style='margin-top: -30px;'>Recuperación de contraseña</i> </h6>
                
                <form>
                  <div id="frm_email" class="form-floating mb-3"> 
                    <label id="label_user" class="form-control-label text-muted">Usuario</label> 
                    <input type="email" id="email" name="email" class="form-control" value='<?= $email ?>' readonly>
                    <div class="invalid-feedback"></div>
                  </div>


                  <div style='margin-top: 20px;'>
                    <label class="form-control-label text-muted">Nueva contraseña</label> 
                    <div id="frm_passwd" class="input-group"> 
                      <input type="password" id="passwd" name="passwd" style='margin-right: 10px;' placeholder="Ingrese nueva contraseña" class="form-control">
                      <div class="input-group-addon">
                        <a href=""><i class="fa fa-eye-slash" style='margin-top: 10px;' aria-hidden="true"></i></a>
                      </div>
                      <div id='div_err_pass' class="invalid-feedback"></div>
                    </div>
                  </div>

                  <div style='margin-top: 20px;'>
                  <label class="form-control-label text-muted">Repita la nueva contraseña</label> 
                    <div id="frm_passwd_rep" class="input-group"> 
                      <input type="password" id="passwd_rep" name="passwd_rep" style='margin-right: 10px;' placeholder="Ingrese nueva contraseña" class="form-control">
                      <div class="input-group-addon">
                        <a href=""><i class="fa fa-eye-slash" style='margin-top: 10px;' aria-hidden="true"></i></a>
                      </div>
                      <div id='div_err_pass_rep' class="invalid-feedback"></div>
                    </div>
                  </div>
                  <div class="row justify-content-center px-3" style='margin-bottom: 15px; margin-top: 10px'> <button type="button" id="update" class="btn-block btn-color">Guardar</button> </div>
                </form>
            </div>
        </div>
        </div>
    </div>    
</div>

<script>const host_url = "<?php echo base_url(); ?>";</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>

        <!-- Third party plugin JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
        <!-- Contact form JS-->
<script src="<?php echo base_url(); ?>assets/mail/jqBootstrapValidation.js"></script>

        <!-- Core theme JS-->
<script src="<?php echo base_url(); ?>assets/js/scripts.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <!-- Custom scripts for all pages-->
<script src="<?php echo base_url(); ?>assets/js/utils_js/sb-admin-2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/recovery.js"></script>
</body>
</html>

