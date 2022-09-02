
<!-- Button trigger modal 
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
  Launch demo modal
</button>
-->

<!-- Modal -->
<div class="modal fade" id="modalFormProductos" name = "modalFormCategorias" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<?php
					//dep($data);
				?>
				<!-- Es el contenido de la ventana del Modal, "Formulario", se copio desde el "Vali" -->
				<form id = "formProductos" name = "formProductos" class = "form-horizontal">
					<!-- Para obtener el "idRol" que se va utilizar para actualizar -->
					<input type="hidden" id="idProducto" name="idProducto" value="">
					<p class="text-primary"><span class = "required">*</span>Todos los campos son obligatorios</p>

					<div class= "row">
						<div class="col-md-6"> 

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
									<select class="form-control selectpicker" id="listStatus" name = "listStatus" required= "">
										<option value = "1">Activo</option>
										<option value = "2">Inactivo</option>
									</select>
							</div>

						</div> <!-- <div class="col-md-6">  -->

						<!-- Se coloca el codigo HTML para agregar la imagen de la categoria. -->
						<div class="col-md-6"> 

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
<div class="modal fade" id="modalViewCategoria" name = "modalViewCategoria" tabindex="-1" role="dialog"  aria-hidden="true">
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
								<td>ID:</td>
								<td id= "celId"></td>
							</tr>
							<tr>
								<td>Nombres:</td>
								<td id= "celNombre"></td>
							</tr>
							<tr>
								<td>Descripcion:</td>
								<td id= "celDescripcion"></td>
							</tr>
							<tr>
								<td>Estado:</td>
								<td id= "celEstado"></td>
							</tr>
							<tr>
								<td>Foto:</td>
								<td id= "imgCategoria"></td>
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
