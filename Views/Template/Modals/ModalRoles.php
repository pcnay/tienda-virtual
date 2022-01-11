
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
				<!-- Es el contenido de la ventana del Modal, "Formulario"-->
				
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

<!--  Pantalla para los permisos de los Roles  -->
<!-- Extra large modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-xl">Extra large modal</button>

<div class="modal fade modalPermisos" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title h4">Permisos Roles de Usuarios</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> 		<span aria-hidden="true">x</span>
					</button>
			</div>
			<div class="modal-body">
			<div class="col-md-12">
          <div class="tile">
            <form action="" id="formPermisos" name="formPermisos"></form>
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th>#</th>
											<th>Módulod</th>
											<th>Leer</th>
											<th>Escribir</th>
											<th>Actualizar</th>
											<th>Eliminar</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Usuario</td>
											<td>
												<div class="toggle-flip">
													<label>
														<input type="checkbox"><span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
													</label>
												</div>
											</td>
											<td>
												<div class="toggle-flip">
													<label>
														<input type="checkbox"><span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
													</label>
												</div>
											</td>
											<td>
												<div class="toggle-flip">
													<label>
														<input type="checkbox"><span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
													</label>
												</div>
											</td>
											<td>
												<div class="toggle-flip">
													<label>
														<input type="checkbox"><span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
													</label>
												</div>
											</td>
											<td>
												<div class="toggle-flip">
													<label>
														<input type="checkbox"><span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
													</label>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="text-center">
								<button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle" aria-hidden="true"></i>Guardar</button>						
								<button class="btn btn-danger" type="button" data-dismiss="modal"><i class="app-menu_icon fas fa-sign-out-alt" aria-hidden="true"></i>Salir</button>						
							</div>
						</form>
						
          </div>
        </div>
			</div> <!-- <div class="modal-body">-->
    </div>
  </div>
</div>


