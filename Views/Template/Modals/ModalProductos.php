
<!-- Button trigger modal 
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
  Launch demo modal
</button>
-->

<!-- Modal -->
<div class="modal fade" id="modalFormProductos" name = "modalFormProductos" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-xl" > <!-- modal-lg = Modal anterior, con xl = mas grande -->
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
						<div class="col-md-8"> <!-- Esta numero se modifica para aumentar el ancho del codigo de barras, puede ser a 6-->

							<div class="form-group">
								<label class="control-label">Nombre Producto<span class = "required">*</span></label>
								<input class="form-control" type="text" id ="txtNombre" name = "txtNombre" maxlength="100" required="">
							</div>
							<div class="form-group">
								<label class="control-label">Descripcion Producto </label>
								<textarea class="form-control" id = "txtDescripcion" name = "txtDescripcion" rows="4"
								></textarea>
							</div>

						</div> <!-- <div class="col-md-8">  -->

						<!-- Se coloca el codigo HTML para agregar la imagen de la categoria. -->
						<!-- Se modifican las columnas de la vistas que se utilizaran en la capturas de registros.-->
						<!-- Se implementa la maquetacion de Grid de 12 Columnas -->
						<div class="col-md-4"> 
							<div class="form-group">
								<label class="control-label">Código<span class="required">*</span>
								</label>
								<input class="form-control" id="txtCodigo" name="txtCodigo" type="text" placeholder="Codigo de Barras" maxlength="24" required= "">
								<br> <!-- Dejar un renglon de espacio --> 

								<div id="divBarCode" class="notBlock textcenter">
									<div id="printCode"> <!-- Para imprimir el codigo de barras -->
										<!-- Es donde se muestra el código de barra -->
										<svg id="barcode">
										</svg>
									</div>
									<button class="btn btn-success btn-sm" type="button" onClick= "fntPrintBarcode('#printCode')"><i class="fas fa-print"></i>Imprimir</button>
								</div> <!-- <div id="divBarCode" class="notBlock textcenter"> -->

							</div> <!-- <div class="form-group"> -->

							<div class="row"> <!-- Define una fila -->

								<!-- Se definen dos renglones para colocar Precio y Stock --> 
								<div class="form-group col-md-6">
									<!-- Fila para la seccion -->
									<label class="control-label">Precio<span class="required">*</span></label>
									<input class="form-control" id="txtPrecio" name="txtPrecio" type="text" required= "">
								</div>

								<div class="form-group col-md-6">
									<!-- Fila para la seccion -->
									<label class="control-label">Stock<span class="required">*</span></label>
									<input class="form-control" id="txtStock" name="txtStock" type="text" required= "">
								</div>

							</div> <!-- <div class="row"> -->	

							<!-- Seccion donde se muestran las Categorias -->
							<div class="row"> <!-- Se define un renglon para agregar las etiquetas  -->

								<div class="form-group col-md-6">
									<label for="listaCategoria">Categoria<span class="required">*</span></label>
									<!-- data-live-search="true" = Se utiliza para buscar en el ComboBox -->
									<select class="form-control" data-live-search="true" id="listCategoria" name="listCategoria" required=""></select>				
								</div>

								<!-- Select - Combobox -->
								<div class="form-group">
									<label for="listStatus">Estado<span class = "required">*</span></label>
									<select class="form-control selectpicker" id="listStatus" name = "listStatus" required= "">
										<option value = "1">Activo</option>
										<option value = "2">Inactivo</option>
									</select>
								</div>
							
							</div> <!-- <div class="row"> -->	

							<!-- Para mostrar el boton  -->
							<div class="row">
								
								<div class="form-group col-md-6">
									<!-- data-dismiss = Para que se cierre el Modal al oprimir el boton "Cancelar" -->
										<button id = "btnActionForm" class="btn btn-primary btn-lg btn-block" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>
								</div><!-- <div class="form-group col-md-6"> -->

								<div class="form-group col-md-6">
									<!-- data-dismiss="modal" = Para cerrar el Modal -->
									<button class = "btn btn-danger btn-lg btn-block" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-check-circle"></i>Cerrar</button>
								</div><!-- <div class="form-group col-md-6">-->

							</div> <!-- <div class="row" -->								
							
						</div> <!-- <div class="col-md-4">  -->

					</div> <!-- <div class= "row"> -->

					<!-- =======================================================================  --> 
					<!-- Seccion donde se mostrara las imagenes en la captura de productos  -->
					<!-- =======================================================================  --> 
					<div class="title-footer">
						
						<!-- Ocupara el ancho de su contenedor -->
						<div class="form-group col-md-12">
							<div id="containerGallery">
								<span>Agregar foto (440 Ancho x 545 Largo) </span>
								<button class="btnAddImage btn btn-info btn-sm" type="button"><i class="fas fa-plus"></i></button>
							</div>
							<hr>
							<div id="containerImages">
								<!-- Se agregan los recuadros para los gráficos de los productos de forma dinámica creada en JavaScript -->
							</div> <!-- <div id="containerImages"> -->

						</div> <!-- <div class="form-group col-md-12"> -->

					</div> <!-- <div class="title-footer"> -->
						
					<!-- =======================================================================  --> 		
					
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
<div class="modal fade" id="modalViewProducto" name = "modalViewProducto" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos Del Producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<div class ="modal-body">
					<table class = "table table-bordered">
						<tbody>

							<tr>
								<td>Codigo :</td>
								<td id= "celCodigo"></td>
							</tr>
							<tr>
								<td>Nombres:</td>
								<td id= "celNombre"></td>
							</tr>
							<tr>
								<td>Precio:</td>
								<td id= "celPrecio"></td>
							</tr>
							<tr>
								<td>Stock:</td>
								<td id= "celStock"></td>
							</tr>
							<tr>
								<td>Categoria:</td>
								<td id= "celCategoria"></td>
							</tr>
							<tr>
								<td>Status:</td>
								<td id= "celStatus"></td>
							</tr>
							<tr>
								<td>Descripcion:</td>
								<td id= "celDescripcion"></td>
							</tr>
							<tr>
								<td>Foto De Transferencia:</td>
								<td id= "celFotos"></td>
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
