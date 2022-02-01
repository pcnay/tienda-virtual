<!-- Para que despliegue la informacion en el "TAB" desde el arreglo "$data" -->
<?php 
	headerAdmin($data); 
	getModal('ModalRoles',$data);	// Para mostrar el Modal.
	//getRoles();
?>

	<!-- Se crea el <DIV> donde se colocara el código HTML que se genero en "function_roles.js"  -->
	<div id="contentAjax"> </div>
	
	<!-- Sidebar menu-->
	<main class="app-content">
		<div class="app-title">
			<div>			
				<!-- Para mostrar un icono en la Vista de roles "fas fa-user-tag" ; Espacio entre el Icono y el Texto "Roles Usuarios" -->
				<h1><i class="fas fa-user-tag"> </i>  <?php   echo $data['page_title']; ?>

					<!-- Agregando el boton de "Agregar" un Rol al Usuario. Se define "openModal()" en  Assets/js/Functions_roles.js--> 
					<button class="btn btn-primary" type="button" onclick="openModal();"><i class="fas fa-plus-circle"></i>Nuevo</button>
				
				</h1>

				<p></p>
			</div>
			<ul class="app-breadcrumb breadcrumb">
				<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
				<!-- /Roles = Es el Controlador que buscara -->
				<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>/Roles"><?php echo $data['page_title']; ?></a></li>
			</ul>
		</div>

		<!-- Sección para incrustar el DataTable -->
		<div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="tableRoles">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nombre</th>
                      <th>Descripcion</th>
                      <th>Status</th>
											<th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>


	</main>
<?php footerAdmin($data); ?>