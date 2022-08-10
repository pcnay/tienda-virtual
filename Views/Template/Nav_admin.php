<!-- Para realizar la modificacion de los iconos del sistema : https://fontawesome.com/v4.7.0/icons-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?php echo media(); ?>/images/avatar.png" alt="User Image">
        <div>
          <p class="app-sidebar__user-name"><?=$_SESSION['userData']['nombres']; ?></p>
          <p class="app-sidebar__user-designation"><?=$_SESSION['userData']['nombrerol']; ?></p>
        </div>
      </div>
      <ul class="app-menu">
				<!-- Es el ID que le corresponde en la tabla "t_Roles" para "Dashboard" -->
				<?php if (!empty($_SESSION['permisos'][1]['r'])){ ?>
					<li><a class="app-menu__item" href="<?php echo base_url(); ?>/Dashboard"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
				<?php } ?>

				<!-- Es el ID que le corresponde en la tabla "t_Roles" para "Usuarios" -->			
				<?php if (!empty($_SESSION['permisos'][2]['r'])){ ?>
					<li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview">
						<!-- <i class="app-menu__icon fa 				fa-laptop"></i> Cuando se agrege otro icono debe ser de esta manera --> 
						<i class="app-menu__icon fa fa-users" aria-hidden="true"></i>
						<span class="app-menu__label">Usuarios</span><i class="treeview-indicator fa 	fa-angle-right"></i></a>
						<ul class="treeview-menu">
							<li><a class="treeview-item" href="<?php echo base_url(); ?>/Usuarios"><i class="icon fa fa-circle-o"></i>Usuarios</a></li>
							<li><a class="treeview-item" href="<?php echo base_url(); ?>/Roles"><i class="icon fa fa-circle-o"></i>Roles</a></li>
						</ul>
					</li>          
				<?php } ?>	

				<!-- Es el ID que le corresponde en la tabla "t_Roles" para "Clientes" -->
				<?php if (!empty($_SESSION['permisos'][3]['r'])){ ?>		
        <li>
					<a class="app-menu__item" href="<?php echo base_url(); ?>/Clientes">
						<i class="app-menu__icon fa fa-user" aria-hidden="true"></i>
							<span class="app-menu__label">Clientes</span>
					</a>
				</li>
				<?php } ?>

				<!-- Es el ID que le corresponde en la tabla "t_Roles" para "Dashboard" -->	
				<!-- permiso[4] = Tienda; permiso[6] = Categorias --> 		
				<?php if ((!empty($_SESSION['permisos'][4]['r'])) || (!empty($_SESSION['permisos'][6]['r']))) { ?>
					<li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview">
						<!-- <i class="app-menu__icon fa 				fa-laptop"></i> Cuando se agrege otro icono debe ser de esta manera --> 
						<i class="app-menu__icon fa fa-archive" aria-hidden="true"></i>
						<span class="app-menu__label">Tienda</span><i class="treeview-indicator fa 									fa-angle-right"></i></a>
						<ul class="treeview-menu">

							<!-- permisos[5] = Productos; -->
							<?php if (!empty($_SESSION['permisos'][5]['r'])) { ?>
								<li><a class="treeview-item" href="<?php echo base_url(); ?>/Productos"><i class="icon fa fa-circle-o"></i>Productos</a></li>
							<?php } ?>	

							<!-- permisos[6] = Categorias -->
							<?php if (!empty($_SESSION['permisos'][6]['r'])) { ?>
								<li><a class="treeview-item" href="<?php echo base_url(); ?>/Categorias"><i class="icon fa fa-circle-o"></i>Categorias</a></li>
							<?php } ?>

						</ul>
					</li>          
					
				<?php } ?>

				<?php if (!empty($_SESSION['permisos'][5]['r'])){ ?>
        <li>
					<a class="app-menu__item" href="<?php echo base_url(); ?>/Pedidos">
						<i class="app-menu__icon fa fa-shopping-cart" aria-hidden="true"></i>
							<span class="app-menu__label">Pedidos</span>
					</a>
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
