<!-- Para que despliegue la informacion en el "TAB" desde el arreglo "$data" -->
<?php headerAdmin($data); ?>

	<!-- Sidebar menu-->
	<main class="app-content">
		<div class="app-title">
			<div>
				<h1><i class="fa fa-dashboard"></i><?php echo $data['page_title']; ?></h1>
				<p></p>
			</div>
			<ul class="app-breadcrumb breadcrumb">
				<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
				<li class="breadcrumb-item"><a href="<?= base_url(); ?>/Dashboard">Dashboard</a></li>
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="tile">
					<div class="tile-body">Dashboard</div>
					<!-- Se puede usar, porque en el constructor de Dashboard se ejecuta "session_start()" -->
					<?php //dep($_SESSION['userData']);
								//getPermisos(1);
								//dep(getPermisos(11));								
								//dep($_SESSION['permisos']);
								//dep($_SESSION['permisosMod']);
								
					?>

				</div>
			</div>
		</div>
	</main>
<?php footerAdmin($data); ?>