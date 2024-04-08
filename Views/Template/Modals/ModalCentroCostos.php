
<!-- Button trigger modal 
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
  Launch demo modal
</button>
-->

<!-- Modal -->
<div class="modal fade" id="modalFormCentroCostos" name= "modalFormCentroCostos" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Centro Costos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<?php
					//dep($data);
				?>
				<!-- Es el contenido de la ventana del Modal, "Formulario", se copio desde el "Vali" -->
				<form id = "formCentroCostos" name = "formCentroCostos" class = "form-horizontal">
					<!-- Para obtener el "idCentroCostos" que se va utilizar para actualizar -->
					<input type="hidden" id="idCentroCostos" name="idCentroCostos" value="">
					<p class="text-primary"><span class = "required">*</span>Todos los campos son obligatorios</p>

					<div class= "row">
						<div class="col-md-6"> 

							<div class="form-group">
								<label class="control-label">Numero Centro De Costos<span class = "required">*</span></label>
								<input class="form-control" type="text" id ="txtNumCentroCostos" name = "txtNumCentroCostos" placeholder="Numero Centro De Costos" maxlength="30" required="">
							</div>

							<div class="form-group">
								<label class="control-label">Descripcion<span class = "required">*</span></label>
								<input class="form-control" type="text" id ="txtDescripcion" name = "txtDescripcion" placeholder="Descripcion Centro De Costos" maxlength="80" required="">
							</div>

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
<div class="modal fade" id="modalViewCentroCostos" name = "modalViewCentroCostos" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos Del Centro De Costos</h5>
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
								<td>Num Centro Costos:</td>
								<td id= "celNumCentroCostos"></td>
							</tr>
							<tr>
								<td>Descripcion:</td>
								<td id= "celDescripcion"></td>
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
