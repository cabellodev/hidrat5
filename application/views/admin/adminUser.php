<div id="content-wrapper">
  <div class="container-fluid mb-5">

    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Usuarios / Empresa</li>
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
            En esta Pantalla se podra administrar todos los usuarios que trabajaran con el sistema, ya sea poder editarlos, agregar nuevos o bien bloquearles el acceso al sistema
          </div>
        </div>
      </div>
    </div>

    <div class="card mb-3">
      <div class="card-header">
        <i class="fas fa-table"></i>
        Lista de usuarios
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="table-usuario" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Rut</th>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Rango</th>
                <th>Editar</th>
                <th>Bloquear/Desbloquear</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
    <div style="padding-right: 40px">
      <button class="btn btn-success float-right" type='button' data-toggle="modal" data-target="#agregarUser" id="btn"><i class="fas fa-plus"></i> Agregar Usuario</button>
    </div>
    <div class="row mb-3"></div>

  </div>
</div>


<div class="modal fade bd-example-modal-lg" id="agregarUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titulo">Agregar Usuario</h5>
        <button type="button" class="close"  data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm">
            <p id="UserModalInfo"></p>
          </div>
        </div>
        <div class="form-group">
          <div class="row mb-2">
            <div class="col-md-12 col-lg-6 control-label">
              <label for="actividad">Rut</label>
              <input type="text" class="form-control" id="rut" name="rut">
              <div class="invalid-feedback rut" style="display: none;  color:red">
                Ingrese un Rut porfavor.
              </div>
            </div>
            <div class="col-md-12 col-lg-6 control-label">
              <label for="actividad">Nombre completo</label>
              <input type="text" class="form-control" name="name" id="name">
              <div class="invalid-feedback name" style="display: none;  color:red">
                Ingrese su Nombre completo porfavor.
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-md-12 col-lg-6 control-label">
              <label for="actividad">Email</label>
              <input type="text" class="form-control" name="email" id="email">
              <div class="invalid-feedback email" style="display: none;  color:red">
                Ingrese un Email porfavor.
              </div>
            </div>
            <div class="col-md-12 col-lg-6 control-label">
              <label for="actividad">Rango</label>
              <select class="custom-select d-block w-100" id="rango" required="">
                <option value="0">Opciones...</option>
                <option value="Administrador">Administrador</option>
                <option value="Invitado">Invitado</option>
                
              </select>
              <div class="invalid-feedback rango" style="display: none;  color:red">
                Seleccione un rango porfavor.
              </div>
            </div>
          </div>
          <div class="row" id="passdiv">
            <div class="col-md-12 col-lg-6 control-label">
              <label for="actividad">Contraseña</label>
              <input type="password" class="form-control" name="passwd" id="passwd">
              <div class="invalid-feedback passwd" style="display: none;  color:red">
                Ingrese una Contraseña porfavor.
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" id="addUser" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo base_url(); ?>assets/vendor/jquery.rut.js"></script>
<script src="<?php echo base_url(); ?>assets/js_admin/adminUser.js"></script>

