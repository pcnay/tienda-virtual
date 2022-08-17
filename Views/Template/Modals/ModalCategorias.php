
<!-- Button trigger modal 
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
  Launch demo modal
</button>
-->

<!-- Modal -->
<div class="modal fade" id="modalFormCategorias" name = "modalFormCategorias" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Categoria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<?php
					//dep($data);
				?>
				<!-- Es el contenido de la ventana del Modal, "Formulario", se copio desde el "Vali" -->
				<form id = "formCategoria" name = "formCategoria" class = "form-horizontal">
					<!-- Para obtener el "idRol" que se va utilizar para actualizar -->
					<input type="hidden" id="idUsuario" name="idUsuario" value="">
					<p class="text-primary"><span class = "required">*</span>Todos los campos son obligatorios</p>

					<div class= "row">
						<div class="col-md-6"> 

							<!-- Para obtener el "idRol" que se va utilizar para actualizar -->
							<input type="hidden" id="idCategoria" name="idCategoria" value="">
							<div class="form-group">
								<label class="control-label">Nombre<span class = "required">*</span></label>
								<input class="form-control" type="text" id ="txtNombre" name = "txtNombre" placeholder="Nombre Categoria" required="">
							</div>
							<div class="form-group">
								<label class="control-label">Descripcion<span class = "required">*</span></label>
								<textarea class="form-control" rows="2" id = "txtDescripcion" name = "txtDescripcion" placeholder="Descripcion De Categoria" required =""></textarea>
							</div>

							<!-- Select - Combobox -->
							<div class="form-group">
									<label for="exampleSelect1">Estado<span class = "required">*</span></label>
									<select class="form-control" id="listStatus" name = "listStatus" required= "">
										<option value = "1">Activo</option>
										<option value = "2">Inactivo</option>
									</select>
							</div>

						</div> <!-- <div class="col-md-6">  -->

						<!-- Se coloca el codigo HTML para agregar la imagen de la categoria. -->
						<div class="col-md-6"> 
							<div class="photo">
								<label for="foto">Foto (570x380)</label>
								<div class="prevPhoto">
									<span class="delPhoto notBlock">X</span>
									<label for="foto"></label>
									<div>
										<img id="img" src="<?= media(); ?>/images/uploads/portada_categoria.png">
									</div>
								</div>
								<div class="upimg">
									<input type="file" name="foto" id="foto">
								</div>
								<div id="form_alert"></div>
								
							</div> <!-- <div class="photo"> -->

						</div> <!-- <div class="col-md-6">  -->


					</div> <!-- <div class= "row"> -->

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
