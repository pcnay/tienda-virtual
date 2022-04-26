
<!-- Button trigger modal 
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
  Launch demo modal
</button>
-->

<!-- Modal -->
<div class="modal fade" id="modalFormUsuario" name = "modalFormUsuario" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<?php
					//dep($data);
				?>
				<!-- Es el contenido de la ventana del Modal, "Formulario", se copio desde el "Vali" -->
				<form id = "formUsuario" name = "formUsuario" class = "form-horizontal">
					<!-- Para obtener el "idRol" que se va utilizar para actualizar -->
					<input type="hidden" id="idUsuario" name="idUsuario" value="">
					<p class="text-primary">Todos los campos son obligatorios</p>

					<div class="form-row">
						<div class="form-group col-md-6">
							<label for = "txtIdentificacion">Identificacion</label>
							<input class="form-control" type="text" id ="txtIdentificacion" name = "txtIdentificacion" placeholder="Ingresa Idenfificacion" required="">
						</div>
					</div> <!-- <div class="form-row" -->

					<div class="form-row">
						<div class="form-group col-md-6">
							<label for = "txtNombre">Nombres</label>
							<input class="form-control" type="text" id ="txtNombre" name = "txtNombre" placeholder="Ingresa Nombre" required="">
						</div>
						<div class="form-group col-md-6">
							<label for = "txtApellido">Apellidos</label>
							<input class="form-control" type="text" id ="txtApellido" name = "txtApellido" placeholder="Ingresa Apellido" required="">
						</div>
					</div> <!-- <div class="form-row" -->

					<div class="form-row">
						<div class="form-group col-md-6">
							<label for = "txtTelefono">Telefonos</label>
							<input class="form-control" type="text" id ="txtTelefono" name = "txtTelefono" placeholder="Ingresa Telefono" required="">
						</div>
						<div class="form-group col-md-6">
							<label for = "txtEmail">Email</label>
							<input class="form-control" type="email" id ="txtEmail" name = "txtEmail" placeholder="Ingresa Email" required="">
						</div>
					</div> <!-- <div class="form-row" -->

					<div class="form-row">
						<div class="form-group col-md-6">
							<label for = "listRolid">Tipo Usuarios</label>
							<!-- Se utilizara Ajax para extraer todos los roles.-->
							<select class = "form-control" data-live-search="true" id = "listRolid" name = "listRolid" required >								
							</select>
						</div>
						<div class="form-group col-md-6">
							<label for = "txtStatus">Status</label>
							<select class = "form-control selectpicker" id = "listStatus" name = "listStatus" required >								
								<option value="1">Activos</option>
								<option value="2">Inactivos</option>
							</select>
						</div>
					</div> <!-- <div class="form-row" -->

					<div class="form-row">
						<div class="form-group col-md-6">
							<label for = "txtPassword">Password</label>
							<input class="form-control" type="password" id ="txtPassword" name = "txtPassword" >
						</div>
					</div> <!-- <div class="form-row" -->

					<!-- data-dismiss = Para que se cierre el Modal al oprimir el boton "Cancelar" -->
					<div class="tile-footer">
						<button id = "btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp; 
						
						<button class = "btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-check-circle"></i>Cerrar</button>

					</div>
					
				</form>      
      </div> <!-- <div class="modal-body"> -->
    </div>
  </div>
</div>





