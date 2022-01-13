<!--  Pantalla para los permisos de los Roles  -->
<!-- Extra large modal -
<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-xl">Extra large modal</button> -->


<div class="modal fade modalPermisos" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title h4">Permisos Roles de Usuarios</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> 		<span aria-hidden="true">x</span>
					</button>
			</div>
			<div class="modal-body">
				<?php
					//dep($data);
				?>
			<div class="col-md-12">
          <div class="tile">
            <form action="" id="formPermisos" name="formPermisos"></form>
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th>#</th>
											<th>Módulo</th>
											<th>Leer</th>
											<th>Escribir</th>
											<th>Actualizar</th>
											<th>Eliminar</th>
										</tr>
									</thead>
									<tbody>
										<?php 
											$no=1;
											$modulos = $data['modulos'];
											for($i=0;$i<count($modulos);$i++)
											{
												$permisos = $modulos[$i]['permisos'];
												$rCheck = $permisos['r'] == 1 ? "checked":"";
												$wCheck = $permisos['w'] == 1 ? "checked":"";
												$uCheck = $permisos['u'] == 1 ? "checked":"";
												$dCheck = $permisos['d'] == 1 ? "checked":"";

												$idmod = $modulos[$i]['id_modulo'];											
										?>
										<tr>
											<td>
												<?php echo $no; ?>
												<input type="hidden" name="modulos[<?= $i; ?>][id_modulo]" value="<?= $idmod ?>" required>
											</td>
											<td>
												<?= $modulos[$i]['titulo']; ?>
											</td>
											<td>
												<div class="toggle-flip">
													<label>
														<input type="checkbox" name="modulos[<?= $i; ?>][r]" <?= $rCheck ?>><span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
													</label>
												</div>
											</td>
											<td>
												<div class="toggle-flip">
													<label>
														<input type="checkbox" name="modulos[<?= $i; ?>][w]" <?= $wCheck ?>><span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
													</label>
												</div>
											</td>
											<td>
												<div class="toggle-flip">
													<label>
														<input type="checkbox" name="modulos[<?= $i; ?>][u]" <?= $uCheck ?>><span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
													</label>
												</div>
											</td>
											<td>
												<div class="toggle-flip">
													<label>
														<input type="checkbox" name="modulos[<?= $i; ?>][d]" <?= $dCheck ?>><span class="flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
													</label>
												</div>
											</td>
										</tr>
										<?php
											$no++;
											} // for 
										?>

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
