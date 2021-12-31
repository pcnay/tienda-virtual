<!-- Para realizar la modificacion de los iconos del sistema : https://fontawesome.com/v4.7.0/icons-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?php echo media(); ?>/images/avatar.png" alt="User Image">
        <div>
          <p class="app-sidebar__user-name">Abel</p>
          <p class="app-sidebar__user-designation">Administrador</p>
        </div>
      </div>
      <ul class="app-menu">
        <li><a class="app-menu__item" href="<?php echo base_url(); ?>/Dashboard"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview">
					<!-- <i class="app-menu__icon fa 				fa-laptop"></i> Cuando se agrege otro icono debe ser de esta manera --> 
					<i class="app-menu__icon fa fa-users" aria-hidden="true"></i>
					<span class="app-menu__label">Usuarios</span><i class="treeview-indicator fa 									fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="<?php echo base_url(); ?>/Usuarios"><i class="icon fa fa-circle-o"></i>Usuarios</a></li>
            <li><a class="treeview-item" href="<?php echo base_url(); ?>/Roles"><i class="icon fa fa-circle-o"></i>Roles</a></li>
            <li><a class="treeview-item" href="<?php echo base_url(); ?>/Permisos"><i class="icon fa fa-circle-o"></i>Permisos</a></li>
          </ul>
        </li>          
        <li>
					<a class="app-menu__item" href="<?php echo base_url(); ?>/Clientes">
						<i class="app-menu__icon fa fa-user" aria-hidden="true"></i>
							<span class="app-menu__label">Clientes</span>
					</a>
				</li>
        <li>
					<a class="app-menu__item" href="<?php echo base_url(); ?>/Productos">
						<i class="app-menu__icon fa fa-archive" aria-hidden="true"></i>
							<span class="app-menu__label">Productos</span>
					</a>
				</li>
        <li>
					<a class="app-menu__item" href="<?php echo base_url(); ?>/Pedidos">
						<i class="app-menu__icon fa fa-shopping-cart" aria-hidden="true"></i>
							<span class="app-menu__label">Pedidos</span>
					</a>
				</li>
        <li>
					<a class="app-menu__item" href="<?php echo base_url(); ?>/Logout">
						<i class="app-menu__icon fa fa-sign-out" aria-hidden="true"></i>
							<span class="app-menu__label">Logout</span>
					</a>
				</li>

			</ul>
    </aside>
