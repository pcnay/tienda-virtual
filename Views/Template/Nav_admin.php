<!-- Para realizar la modificacion de los iconos del sistema : https://fontawesome.com/v4.7.0/icons-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?php echo media(); ?>/images/avatar.png" alt="User Image">
        <div>
          <p class="app-sidebar__user-name"><?=$_SESSION['userData']['nombre_completo']; ?></p>
          <p class="app-sidebar__user-designation"><?=$_SESSION['userData']['nombrerol']; ?></p>
        </div>
      </div>
      <ul class="app-menu">
				<!-- Es el ID que le corresponde en la tabla "t_Roles" para "Dashboard" -->
				<?php if (!empty($_SESSION['permisos'][1]['r'])){ ?>
					<li><a class="app-menu__item" href="<?php echo base_url(); ?>/Dashboard"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
				<?php } ?>

				<!-- Es el ID que le corresponde en la tabla "t_Modulos" para "Modulos" -->			
				<?php if (!empty($_SESSION['permisos'][5]['r'])){ ?>
					<li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview">
						<!-- <i class="app-menu__icon fa 				fa-laptop"></i> Cuando se agrege otro icono debe ser de esta manera --> 
						<i class="app-menu__icon fa fa-users" aria-hidden="true"></i>
						<span class="app-menu__label">Modulos</span><i class="treeview-indicator fa 	fa-angle-right"></i></a>
						<ul class="treeview-menu">
							<li><a class="treeview-item" href="<?php echo base_url(); ?>/Modulos"><i class="icon fa fa-circle-o"></i>Modulos</a></li>
							<li><a class="treeview-item" href="<?php echo base_url(); ?>/Roles"><i class="icon fa fa-circle-o"></i>Roles</a></li>
						</ul>
					</li>          
				<?php } ?>	

				<!-- Es el ID que le corresponde en la tabla "t_Modulos" para "Usuarios" -->			
				<?php if (!empty($_SESSION['permisos'][2]['r'])){ ?>
					<li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview">
						<!-- <i class="app-menu__icon fa 				fa-laptop"></i> Cuando se agrege otro icono debe ser de esta manera --> 
						<i class="app-menu__icon fa fa-users" aria-hidden="true"></i>
						<span class="app-menu__label">Usuarios</span><i class="treeview-indicator fa 	fa-angle-right"></i></a>
						<ul class="treeview-menu">
							<li><a class="treeview-item" href="<?php echo base_url(); ?>/Usuarios"><i class="icon fa fa-circle-o"></i>Usuarios</a></li>
							<!-- <li><a class="treeview-item" href="<?php echo base_url(); ?>/Roles"><i class="icon fa fa-circle-o"></i>Roles</a></li> -->
						</ul>
					</li>          
				<?php } ?>	

				<!-- Es el ID que le corresponde en la tabla "t_Modulos" para "Clientes" -->
				<?php if (!empty($_SESSION['permisos'][3]['r'])){ ?>		
        <li>
					<a class="app-menu__item" href="<?php echo base_url(); ?>/Clientes">
						<i class="app-menu__icon fa fa-user" aria-hidden="true"></i>
							<span class="app-menu__label">Clientes</span>
					</a>
				</li>
				<?php } ?>

				<!-- Es el ID que le corresponde en la tabla "t_Roles" para "Dashboard" -->	
				<!-- permiso[4] = Producto; permiso[6] = Categorias --> 		
				<?php if ((!empty($_SESSION['permisos'][4]['r'])) || (!empty($_SESSION['permisos'][6]['r']))) { ?>
					<li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview">
						<!-- <i class="app-menu__icon fa fa-laptop"></i> Cuando se agrege otro icono debe ser de esta manera --> 
						<i class="app-menu__icon fa fa-archive" aria-hidden="true"></i>
						<span class="app-menu__label">Productos</span><i class="treeview-indicator fa fa-angle-right"></i></a>
						<ul class="treeview-menu">

							<!-- permisos[4] = Productos; -->
							<?php if (!empty($_SESSION['permisos'][4]['r'])) { ?>
								<li><a class="treeview-item" href="<?php echo base_url(); ?>/Productos"><i class="icon fa fa-circle-o"></i>Productos</a></li>
							<?php } ?>	
							
							<!-- permisos[9] = Modelos -->
							<?php if (!empty($_SESSION['permisos'][9]['r'])) { ?>
								<li><a class="treeview-item" href="<?php echo base_url(); ?>/Modelos"><i class="icon fa fa-circle-o"></i>Modelos</a></li>
							<?php } ?>	

							<!-- permisos[12] = Departamento -->
							<?php if (!empty($_SESSION['permisos'][12]['r'])) { ?>
								<li><a class="treeview-item" href="<?php echo base_url(); ?>/Deptos"><i class="icon fa fa-circle-o"></i>Departamento Asignado</a></li>
							<?php } ?>	

							<!-- permisos[6] = Categorias -->
							<?php if (!empty($_SESSION['permisos'][6]['r'])) { ?>
								<li><a class="treeview-item" href="<?php echo base_url(); ?>/Categorias"><i class="icon fa fa-circle-o"></i>Categorias</a></li>
							<?php } ?>

						</ul>
					</li>          
					
				<?php } ?>

				<!-- Es el ID que le corresponde en la tabla "t_Modulos" para "Notas" -->			
				<?php if (!empty($_SESSION['permisos'][10]['r'])){ ?>
					<li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview">
						<!-- <i class="app-menu__icon fa 				fa-laptop"></i> Cuando se agrege otro icono debe ser de esta manera --> 
						<i class="app-menu__icon fa fa-users" aria-hidden="true"></i>
						<span class="app-menu__label">Pendientes</span><i class="treeview-indicator fa 	fa-angle-right"></i></a>
						<ul class="treeview-menu">
							<li><a class="treeview-item" href="<?php echo base_url(); ?>/Notas"><i class="icon fa fa-circle-o"></i>Notas</a></li>
						</ul>
					</li>          
				<?php } ?>	

        <li>
					<a class="app-menu__item" href="<?php echo base_url(); ?>/Logout">
						<i class="app-menu__icon fa fa-sign-out" aria-hidden="true"></i>
							<span class="app-menu__label">Logout</span>
					</a>
				</li>

			</ul>
    </aside>
