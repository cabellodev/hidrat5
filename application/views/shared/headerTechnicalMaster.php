<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="hidratec-admin">
    <meta name="author" content="Sistema Hidratec ">

    <title>Administración Sistema Hidratec</title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url(); ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url(); ?>assets/css_admin/sb-admin-2.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/vendor/DataTables/datatables.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/vendor/jquery-ui-1.12.1.custom/jquery-ui.css" type="text/css" rel="stylesheet"/>
    <script>
    const host_url = "<?php echo base_url(); ?>";
  </script>

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
</head>

<body id="page-top">
<div class="chargePage"></div>
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center pb-4" href="<?php echo base_url(); ?>counterMaster">

            <img src="<?php echo base_url(); ?>assets/img/icon_hidratec.png" style="height:60px ;width:60px"alt="logo images">

            </a>
           

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">

                <a class="nav-link" href="<?php echo base_url(); ?>api/load_page">

                    <i class="fas fa-home"></i>
                    <span>Inicio</span></a>
                    <hr class="sidebar-divider">
            </li>

          
             <!-- Nav Item - Utilities Collapse Menu -->
            

            <!-- Nav Item - Finanzas e Menu -->
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>adminEvaluation">
                <i class="fas fa-brain"></i>
                    <span>Evaluaciones</span></a>
                    <hr class="sidebar-divider">
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>tmAdminstechnicalReport">
                <i class="fas fa-file-invoice"></i>
                    <span>Informes técnicos</span></a>
                    <hr class="sidebar-divider">
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>tmAdminReparation">
                <i class="fas fa-file-invoice"></i>

                    <span>Reparaciones</span></a>
                    <hr class="sidebar-divider">
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>adminHydraulicTest">
                <i class="fas fa-vial"></i>
                    <span>Pruebas hidráulicas</span></a>
                    <hr class="sidebar-divider">
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>searchDocumentation">
                <i class="fas fa-book"></i>
                    <span>Documentaciónes</span></a>
                    <hr class="sidebar-divider">
            </li>

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->
<!------------------------------------------------------      content                                        ------------------------------------------------------------->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-gradient-secondary topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                    <li class="nav-item dropdown no-arrow">
                            
                            <a class="nav-link dropdown-toggle" href="#chat" id="list_notifications" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                <span class="mr-2 d-none d-lg-inline text-white small"></span>
                                    <i class="fa fa-bell" id="alert_notification" style="color:white; font-size:30px"></i>
                                <span class="mr-2 d-none d-lg-inline text-white " ><h5 id="counter"></h5></span>
                            </a>
                            <!-- Dropdown - User Information -->
                  <!--          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <div class="card-body dropdown-item"  href="#chat">
                                <div  id="card_notification" style="height:300px;overflow-y: auto;" >
                                
                                </div>
                                <button class="btn btn-dark"id=btn_history_notification >Historial de notificaciones </button>

                                </div>
                            <div>-->
                        </li>
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-white small"><?php echo $_SESSION['full_name'];?></span>
                                <i class="fas fa-power-off" style="color:white; font-size:20px"></i>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Perfil del usuario 
                                </a>
                            
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal"  data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Cerrar sesión
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->


<!-- Logout Modal Close sesion -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">¿Seguro quieres salir del sistema?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Selecciona "Salir" si deseas cerrar la sesión.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button"  data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" id="logout" >Salir</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_notifications" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog"  style="max-width: 1000px!important;" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="exampleModalLabel">Bandeja de notificaciones</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                <button class="btn btn-success" type="button" id="btn-check-all"  >Ver todo</button>
                <div class="table-responsive">
        
                            <table class="table table-bordered" id="table-notifications" width="100%" cellspacing="0">
                                <thead>
                                         <tr>
                                        
                                            <th>Notificación</th>
                                            <th>Fecha</th>
                                             <th>OT</th>
                                             <th>Check visto</th>
                                           
                                     
                                         </tr>
                                </thead>
                             </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button"  data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" id="logout" >Salir</a>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.2.1/howler.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/DataTables/datatables.min.js"></script>
   <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>-->
   <script src="<?php echo base_url(); ?>assets/sweetalert.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url(); ?>assets/js_admin/sb-admin-2.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js_admin/menu.js"></script>

    <script src="<?php echo base_url(); ?>assets/vendor/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/lodash/lodash.js"></script>
   
   <script src="<?php echo base_url(); ?>assets/js_admin/technical_master/notifications.js"></script>
    

