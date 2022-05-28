<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author" content="Sistema Tienda Virtual">
		<meta name="theme-color" content="#009688">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
		<link rel="shortcut icon" href="<?= media();?>/images/favicon.ico">
		<link rel="stylesheet" type="text/css" href="Assets/css/main.css">
		<link rel="stylesheet" type="text/css" href="Assets/css/styles.css">

    <title><?php echo $data['page_tag']; ?></title>
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <h1><?php echo $data['page_title']; ?></h1>
      </div>
      <div class="login-box">
				<!-- Se suprime "action" porque se utilizara el boton "submit" -->
        <form id="formCambiarPass" name="formCambiarPass" class="forget-form" action="">
          <h3 class="login-head"><i class="fas fa-key"></i>Cambiar Contraseña</h3>
					<input type="hidden" id="idUsuario" name="idUsuario" value="<?= $data['id_persona']; ?>" required>
          <div class="form-group">            
            <input id = "txtPassword" name = "txtPassword" class="form-control" type="password" placeholder="Nueva Contraseña" required>
          </div>
          <div class="form-group">            
            <input id = "txtPasswordConfirm" name = "txtPasswordConfirm" class="form-control" type="password" placeholder="Confirmar Contreaseña" required>
          </div>
          <div class="form-group btn-container">
            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>REINICIAR</button>
          </div>
          <div class="form-group mt-3">
            <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Iniciar Sesion</a></p>
          </div>
        </form>
      </div>
    </section>

		<script>
			// Genera una variable en JavaScript desde PHP.
			const base_url = "<?php echo base_url(); ?>";
		</script>

		<!-- Essential javascripts for application to work-->		
    <script src="<?= media(); ?>/js/jquery-3.3.1.min.js"></script>
    <script src="<?= media(); ?>/js/popper.min.js"></script>
    <script src="<?= media(); ?>/js/bootstrap.min.js"></script>
		<script src="Assets/js/fontawesome.js"></script>
		
    <script src="Assets/js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="<?= media(); ?>/js/plugins/pace.min.js"></script>
		<script type="text/javascript" src="<?= media(); ?>/js/plugins/sweetalert.min.js"></script>
		<script src="Assets/js/<?= $data['page_functions_js']; ?>"></script>
  </body>
</html>