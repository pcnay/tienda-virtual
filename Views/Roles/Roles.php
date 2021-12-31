<!-- Para que despliegue la informacion en el "TAB" desde el arreglo "$data" -->
<?php headerAdmin($data); ?>

	<!-- Sidebar menu-->
	<main class="app-content">
		<div class="app-title">
			<div>			
				<h1><i class="fas fa-user-tag"></i><?php   echo $data['page_title']; ?></h1>
				<p></p>
			</div>
			<ul class="app-breadcrumb breadcrumb">
				<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
				<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>/Roles"><?php echo $data['page_title']; ?></a></li>
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="tile">
					<div class="tile-body">Roles De Usuarios</div>
				</div>
			</div>
		</div>
	</main>
<?php footerAdmin($data); ?>