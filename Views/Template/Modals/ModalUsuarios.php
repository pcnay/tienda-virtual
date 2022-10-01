
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
							<input class="form-control" type="text" id ="txtIdentificacion" name = "txtIdentificacion" placeholder="Ingresa Idenfificacion" maxlength="30" required="">
						</div>
					</div> <!-- <div class="form-row" -->

					<div class="form-row">
						<div class="form-group col-md-6">
							<label for = "txtNombre">Nombres</label>
							<input class="form-control valid validText" type="text" id ="txtNombre" name = "txtNombre" placeholder="Ingresa Nombre" maxlength="80" required="">
						</div>
						<div class="form-group col-md-6">
							<label for = "txtApellido">Apellidos</label>
							<input class="form-control valid validText" type="text" id ="txtApellido" name = "txtApellido" placeholder="Ingresa Apellido" maxlength="100" required="">
						</div>
					</div> <!-- <div class="form-row" -->

					<div class="form-row">
						<div class="form-group col-md-6">
							<label for = "txtTelefono">Telefonos</label>
							<input class="form-control valid validNumber" type="text" id ="txtTelefono" name = "txtTelefono" placeholder="Ingresa Telefono" maxlength="20" required="" onkeypress="return controlTag(event);">
							<!-- Solo escribe numeros. -->
						</div>
						<div class="form-group col-md-6">
							<label for = "txtEmail">Email</label>
							<input class="form-control valid validEmail" type="email" id ="txtEmail" name = "txtEmail" placeholder="Ingresa Email" maxlength="100" required="">
						</div>
					</div> <!-- <div class="form-row" -->

					<div class="form-row">

						<div class="form-group col-md-6">
							<label for="listaRoles">Tipo Usuario</label>
							<select class="form-control" data-live-search = "true" id="listaRoles" name="listaRoles" required></select>				
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


<!-- Button trigger modal 
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
  Launch demo modal
</button>
-->

<!-- Modal -->
<div class="modal fade" id="modalViewUser" name = "modalViewUser" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos Del Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<div class ="modal-body">
					<table class = "table table-bordered">
						<tbody>
							<tr>
								<td>Identificacion:</td>
								<td id= "celIdentificacion">645353535353:</td>
							</tr>
							<tr>
								<td>Nombres:</td>
								<td id= "celNombre">Pedro</td>
							</tr>
							<tr>
								<td>Apellidos:</td>
								<td id= "celApellidos">Fernandez</td>
							</tr>
							<tr>
								<td>Telefonos:</td>
								<td id= "celTelefono">999-99-99</td>
							</tr>
							<tr>
								<td>Email - Usuario:</td>
								<td id= "celEmail">correo@usuario1.com</td>
							</tr>
							<tr>
								<td>Tipo Usuario:</td>
								<td id= "celTipoUsuario">Vendedor</td>
							</tr>
							<tr>
								<td>Estado:</td>
								<td id= "celEstado">Activo</td>
							</tr>
							<tr>
								<td>Fecha Registro:</td>
								<td id= "celFechaRegistro">Fecha Registro></td>
							</tr>

						</tbody>
					</table>
				</div>
					<div class="modal-footer">
						<!-- data-dismiss="modal" = Para cerrar el modal -->
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					</div>
      </div> <!-- <div class="modal-body"> -->
    </div>
  </div>
</div>









