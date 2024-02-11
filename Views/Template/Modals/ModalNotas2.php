
<!-- Button trigger modal 
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
  Launch demo modal
</button>
-->

<!-- Modal -->
<div class="modal fade" id="modalFormNotas" name = "modalFormNotas" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-xl" > <!-- modal-lg = Modal anterior, con xl = mas grande -->
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nueva Nota</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<?php
					//dep($data);
				?>
				<!-- Es el contenido de la ventana del Modal, "Formulario", se copio desde el "Vali" -->
				<form id = "formNotas" name = "formNotas" class = "form-horizontal">
					<!-- Para obtener el "idRol" que se va utilizar para actualizar -->
					<input type="hidden" id="idNota" name="idNota" value="">
					<input type="hidden" id="idPersona" name="idPersona" value=""> 
					<!-- <?php //echo intval($_SESSION['idUser']);?>"> -->
					
					<p class="text-primary"><span class = "required">*</span>Todos los campos son obligatorios</p>

					<div class= "row">
						<div class="col-md-8"> <!-- Esta numero se modifica para aumentar el ancho del codigo de barras, puede ser a 6-->

							<div class="form-group">
								<label class="control-label">Titulo Nota<span class = "required">*</span></label>
								<input class="form-control" type="text" id ="txtTitulo" name = "txtTitulo" maxlength="100" required="">
							</div>
							<div class="form-group">
								<label class="control-label">Descripcion Nota</label>
								<textarea class="form-control" id = "txtDescripcion" name = "txtDescripcion" rows="4"
								></textarea>
							</div>

						</div> <!-- <div class="col-md-8">  -->

						<!-- Se modifican las columnas de la vistas que se utilizaran en la capturas de registros.-->
						<!-- Se implementa la maquetacion de Grid de 12 Columnas -->
						<div class="col-md-4"> 
							<div class="form-group">
								<label for="listaPersonas">Persona Asignada<span class="required">*</span></label>
									<!-- data-live-search="true" = Se utiliza para buscar en el ComboBox -->
									<select class="form-control" data-live-search="true" id="listPersonas" name="listPersonas" required=""></select>				
								<br> <!-- Dejar un renglon de espacio --> 

							</div> <!-- <div class="form-group"> -->

							<div class="row"> <!-- Define una fila -->

								<!-- Se definen dos renglones para colocar Precio y Stock --> 
								<div class="form-group col-md-6">
									<!-- Fila para la seccion -->
									<label class="control-label">Duracion(Dias)<span class="required">*</span></label>
									<input class="form-control" id="txtDuracion" name="txtDuracion" type="number" required= "">
								</div>

								<div class="form-group col-md-6">
									<!-- Select - Combobox -->
									<div class="form-group">
										<label for="listStatus">Estado<span class = "required">*</span></label>
										<select class="form-control selectpicker" id="listStatus" name = "listStatus" required= "">
											<option value = "1">Activo</option>
											<option value = "2">Inactivo</option>
										</select>
									</div>
								</div>

							</div> <!-- <div class="row"> -->	

							<div class="row"> <!-- Define una fila -->								
								<div class="form-group col-md-8">
										<!-- Select - Combobox -->
										<div class="form-group">
											<label for="fecha_nota">Fecha Nota<span class = "required">*</span></label>
											<input class="form-control" id="txtFecha_Nota" name="txtFecha_Nota" type="date" required= "">
										</div>
									</div>

							</div> <!-- <div class="row">--> 
							

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
<div class="modal fade" id="modalViewNota" name = "modalViewNota" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos De La Nota</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<div class ="modal-body">
					<table class = "table table-bordered">
						<tbody>

							<tr>
								<td>ID :</td>
								<td id= "celIdNota"></td>
							</tr>
							<tr>
								<td>Titulo:</td>
								<td id= "celTitulo"></td>
							</tr>
							<tr>
								<td>Descripcion</td>
								<td id= "celDescripcion"></td>
							</tr>
							<tr>
								<td>Asignado</td>
								<td id= "celAsignado"></td>
							</tr>
							<tr>
								<td>Duracion(dias):</td>
								<td id= "celDuracion"></td>
							</tr>
							<tr>
								<td>Estado:</td>
								<td id= "celEstado"></td>
							</tr>
							<tr>
								<td>Fecha Asignado:</td>
								<td id= "celFechaAsignado"></td>
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
