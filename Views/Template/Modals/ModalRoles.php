
<!-- Button trigger modal 
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
  Launch demo modal
</button>
-->

<!-- Modal -->
<div class="modal fade" id="modalFormaRol" name = "modalFormaRol" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Rol</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<?php
					//dep($data);
				?>

				<!-- Es el contenido de la ventana del Modal, "Formulario", se copio desde el "Vali" -->
				
				<div class="tile">
            <div class="tile-body">
              <form id = "formRol" name = "formRol">
								<!-- Para obtener el "idRol" que se va utilizar para actualizar -->
								<input type="hidden" id="idRol" name="idRol" value="">
                <div class="form-group">
                  <label class="control-label">Nombre</label>
                  <input class="form-control" type="text" id ="txtNombre" name = "txtNombre" placeholder="Ingresa Nombre Completo" required="">
                </div>
                <div class="form-group">
                  <label class="control-label">Descripcion</label>
                  <textarea class="form-control" rows="2" id = "txtDescripcion" name = "txtDescripcion" placeholder="Ingresar Descripcion" required =""></textarea>
                </div>

								<!-- Select - Combobox -->
								<div class="form-group">
                    <label for="exampleSelect1">Estado</label>
                    <select class="form-control" id="listStatus" name = "listStatus" required= "">
                      <option value = "1">Activo</option>
											<option value = "2">Inactivo</option>
                    </select>
                </div>

								<!-- data-dismiss = Para que se cierre el Modal al oprimir el boton "Cancelar" -->
								<div class="tile-footer">
									<button id = "btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="#" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
								</div>
								
							</form>
						</div>	
          </div>
      </div>
    </div>
  </div>
</div>





