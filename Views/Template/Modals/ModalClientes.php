
<!-- Button trigger modal 
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
  Launch demo modal
</button>
-->

<!-- Modal -->
<div class="modal fade" id="modalFormCliente" name = "modalFormCliente" tabindex="-1" role="dialog"  aria-hidden="true">
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
				<form id = "formCliente" name = "formCliente" class = "form-horizontal">
					<!-- Para obtener el "idRol" que se va utilizar para actualizar -->
					<input type="hidden" id="idUsuario" name="idUsuario" value="">
					<p class="text-primary">Todos los campos son obligatorios</p>

					<div class="form-row">
						<div class="form-group col-md-4">
							<label for = "txtIdentificacion">Identificacion<span class = "required">*</span></label>
							<input class="form-control" type="text" id ="txtIdentificacion" name = "txtIdentificacion" maxlength="30" placeholder="Ingresa Idenfificacion" required="">
						</div>
						<div class="form-group col-md-4">
							<label for = "txtNombre">Nombres<span class = "required">*</span></label>
							<input class="form-control valid validText" type="text" id ="txtNombre" name = "txtNombre" maxlength="80" placeholder="Ingresa Nombre" required="">
						</div>
						<div class="form-group col-md-4">
							<label for = "txtApellido">Apellidos<span class = "required">*</span></label>
							<input class="form-control valid validText" type="text" id ="txtApellido" name = "txtApellido" maxlength="30" placeholder="Ingresa Apellido" required="">
						</div>
					</div> <!-- <div class="form-row" -->

					<div class="form-row">
						<div class="form-group col-md-4">
							<label for = "txtTelefono">Telefonos<span class = "required">*</span></label>
							<input class="form-control valid validNumber" type="text" id ="txtTelefono" name = "txtTelefono" maxlength="20" placeholder="Ingresa Telefono" required="" onkeypress="return controlTag(event);">
							<!-- Solo escribe numeros. -->
						</div>
						<div class="form-group col-md-4">
							<label for = "txtEmail">Email<span class = "required">*</span></label>
							<input class="form-control valid validEmail" type="email" id ="txtEmail" name = "txtEmail" maxlength="100" placeholder="Ingresa Email" required="">
						</div>
						
						<div class="form-group col-md-4">
							<label for = "txtPassword">Password</label>
							<input class="form-control" type="password" maxlength="75" id ="txtPassword" name = "txtPassword" >
						</div>
					
					</div> <!-- <div class="form-row" -->
					<hr>

					<p class = "text-primary">Datos Fiscales :</p>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label>Identiifcacion Tributaria<span class = "required">*</span></label>
							<input class="form-control" type="text" maxlength="20"  id="txtNit" name="txtNit" required="">
						</div>
						<div class="form-group col-md-6">	
							<label>Nombre Fiscal<span class = "required">*</span></label>
							<input class="form-control" type="text" maxlength="80" id="txtNombreFiscal" name="txtNombreFiscal" required="">          					
						</div>	
						<div class="form-group col-md-12">	
							<label>Direccion Fiscal<span class = "required">*</span></label>
							<input class="form-control" type="text" maxlength="100" id="txtDirFiscal" name="txtDirFiscal" required="">
						</div>                  

					</div>

					<div class="form-row">
					</div>	




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
<div class="modal fade" id="modalViewCliente" name = "modalViewCliente" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos Del Cliente</h5>
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
								<td>Identificacion Tributaria:</td>
								<td id= "celIde">KLK23221</td>
							</tr>
							<tr>
								<td>Nombre Fiscal:</td>
								<td id= "celNomFiscal">Nombre Fiscal</td>
							</tr>
							<tr>
								<td>Direccion Fiscal:</td>
								<td id= "celDirFiscal">Direccion Fiscal</td>
							</tr>
							<tr>
								<td>Fecha Registro:</td>
								<td id= "celFechaRegistro">Fecha Registro</td>
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
