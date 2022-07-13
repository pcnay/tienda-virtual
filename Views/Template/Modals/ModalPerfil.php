
<!-- Button trigger modal 
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
  Launch demo modal
</button>
-->

<!-- Modal -->
<div class="modal fade" id="modalFormPerfil" name = "modalFormPerfil" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header headerUpdate">
        <h5 class="modal-title" id="titleModal">Actualizar Perfil</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<?php
					//dep($data);
				?>
				<!-- Es el contenido de la ventana del Modal, "Formulario", se copio desde el "Vali" -->
				<form id = "formPerfil" name = "formPerfil" class = "form-horizontal">
					<!-- Para obtener el "idRol" que se va utilizar para actualizar -->
					<input type="hidden" id="idUsuario" name="idUsuario" value="">
					<p class="text-primary">Todos los campos son asterisco (<span class="required">*</span>)son bligatorios</p>

					<div class="form-row">
						<div class="form-group col-md-6">
							<label for = "txtIdentificacion">Identificacion<span class="required">*</span></label>
							<input class="form-control" type="text" id ="txtIdentificacion" name = "txtIdentificacion" placeholder="Ingresa Idenfificacion" value = "<?= $_SESSION['userData']['identificacion']; ?>" required="">
						</div>
					</div> <!-- <div class="form-row" -->

					<div class="form-row">
						<div class="form-group col-md-6">
							<label for = "txtNombre">Nombres<span class="required">*</span></label>
							<input class="form-control valid validText" type="text" id ="txtNombre" name = "txtNombre"  value = "<?= $_SESSION['userData']['nombres']; ?>" required="">
						</div>
						<div class="form-group col-md-6">
							<label for = "txtApellido">Apellidos<span class="required">*</span></label>
							<input class="form-control valid validText" type="text" id ="txtApellido" name = "txtApellido" value = "<?= $_SESSION['userData']['apellidos']; ?>" required="">
						</div>
					</div> <!-- <div class="form-row" -->

					<div class="form-row">
						<div class="form-group col-md-6">
							<label for = "txtTelefono">Telefonos<span class="required">*</span></label>
							<input class="form-control valid validNumber" type="text" id ="txtTelefono" name = "txtTelefono" value = "<?= $_SESSION['userData']['telefono']; ?>" required="" onkeypress="return controlTag(event);">
							<!-- Solo escribe numeros. -->
						</div>
						<div class="form-group col-md-6">
							<label for = "txtEmail">Email</label>
							<input class="form-control valid validEmail" type="email" id ="txtEmail" name = "txtEmail" placeholder="Ingresa Email" value = "<?= $_SESSION['userData']['email_user']; ?>" required="" readonly disabled>
						</div>
					</div> <!-- <div class="form-row" -->

					<div class="form-row">
						<div class="form-group col-md-6">
							<label for = "txtPassword">Password</label>
							<input class="form-control" type="password" id ="txtPassword" name = "txtPassword" >
						</div>

						<div class="form-group col-md-6">
							<label for = "txtPasswordConfirm">Confirmar Password</label>
							<input class="form-control" type="password" id ="txtPasswordConfirm" name = "txtPasswordConfirm" >
						</div>
						
					</div> <!-- <div class="form-row" -->

					<!-- data-dismiss = Para que se cierre el Modal al oprimir el boton "Cancelar" -->
					<div class="tile-footer">
						<button id = "btnActionForm" class="btn btn-info" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Actualizar</span></button>&nbsp;&nbsp;&nbsp; 
						
						<button class = "btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-check-circle"></i>Cerrar</button>

					</div>
					
				</form>      
      </div> <!-- <div class="modal-body"> -->
    </div>
  </div>
</div>


