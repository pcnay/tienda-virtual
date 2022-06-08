<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author" content="Sistema Tienda Virtual">
		<meta name="theme-color" content="#009688">
		<link rel="shortcut icon" href="<?= media();?>/images/favicon.ico">
    <!-- Main CSS-->
		<link rel="stylesheet" type="text/css" href="<?= media();?>/css/main.css">
		<link rel="stylesheet" type="text/css" href="<?= media();?>/css/style.css">

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
			<!-- Para que se muestre los campos en el fomrulario "Resetear Constraseña" flipped -->
      <div class="login-box flipped">
				<!-- Formulario para resetear la contraseña-->
				<!-- action = "" debido a que se agregara un evento en el boton Submit, utilizando JavaScript -->
				
        <form class="forget-form" id="formCambiarPass" name="formCambiarPass"  action="">
					<input type="hidden" id="idUsuario" name="idUsuario" value="<?php echo $data['id_persona']; ?>" required>

          <h3 class="login-head"><i class="fas fa-key"></i>Cambiar Contraseña </h3>
          <div class="form-group">            
            <input id="txtPassword" name="txtPassword" class="form-control" type="password" placeholder="Nueva Contraseña" required>
          </div>
					<div class="form-group">            
						<input id="txtPasswordConfirm" name="txtPasswordConfirm" class="form-control" type="password" placeholder="Confirmar Contraseña" required>
          </div>

					<div class="form-group btn-container">
            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>REINICIAR</button>
          </div>

        </form>
      </div>
    </section>

    <!-- Essential javascripts for application to work-->
		<script>
			// Genera una variable en JavaScript desde PHP.
			const base_url = "<?php echo base_url(); ?>";
		</script>


    <script src="<?= media(); ?>/js/jquery-3.3.1.min.js"></script>
    <script src="<?= media(); ?>/js/popper.min.js"></script>
    <script src="<?= media(); ?>/js/bootstrap.min.js"></script>
		<script src="<?= media(); ?>/js/fontawesome.js"></script>
		<script src="<?= media(); ?>/js/main.js"></script>
    <script src="<?= media(); ?>/js/plugins/pace.min.js"></script>
		<script type="text/javascript" src="<?= media(); ?>/js/plugins/sweetalert.min.js"></script>
		<!-- Se tiene que agregar de esta manera para que funcione agregar el archivo .-->
		<script type="text/javascript" src="<?= media(); ?>/js/<?php echo $data['page_functions_js']; ?>"></script>
  </body>
</html>