<!DOCTYPE html>
<html lang="en">
  <head>
		<!-- Es importante esta etiqueta "meta" para los buscadores de Google.  -->
    <meta charset="utf-8">
    <meta name="description" content="Tienda Virtual">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author" content="IT">
		<meta name="theme-color" content="#009688">
		<link rel="shortcut icon" href="Assets/images/favicon.ico">
		<!-- Se utiliza para los Responsive (dispositivos mobiles) -->
    <title><?php echo $data['page_tag']; ?></title>
    <!-- Main CSS-->
		<!-- Es importante la ubicación del archivo ya que primero se aplican los estilos de "main.css" y después "style.css"-->
    <link rel="stylesheet" type="text/css" href="Assets/css/main.css">
		<link rel="stylesheet" type="text/css" href="Assets/css/style.css">
    <!-- Font-icon css-->
		<!-- Se borra porque se agrego la version 6, se incluye como archivo JavaScript en "Footer_admin.php" -->
    <!-- <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <!-- <link rel="stylesheet" type="text/css" href="Assets/css/font_awesome.css">  -->
	</head>
  <body class="app sidebar-mini">
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="<?php echo base_url(); ?>/Dashboard">Tienda Virtual</a>
      <!-- Sidebar toggle button-->
			<!-- NO se requiere agregar : <i class="fas fa-bars"></i> -->
			<a class="app-sidebar__toggle" href="#" 
			data-toggle="sidebar" aria-label="Hide Sidebar"><i class="fas fa-bars"></i></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
				<!-- Se eliminan varias lineas, solo se deja el icono de la persona -->

        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <li><a class="dropdown-item" href="<?php echo base_url(); ?>/Opciones"><i class="fa fa-cog fa-lg"></i> Settings</a></li>
            <li><a class="dropdown-item" href="<?php echo base_url(); ?>/Perfil"><i class="fa fa-user fa-lg"></i> Profile</a></li>
            <li><a class="dropdown-item" href="<?php echo base_url(); ?>/Logout"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
          </ul>
        </li>
      </ul>
    </header>

		<?php require_once("Nav_admin.php"); ?>

