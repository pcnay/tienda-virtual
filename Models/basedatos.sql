/*
-- Cuando se define las tablas deben de ser el motor de Almacenamiento "InnoDB" para que se puedan establecer 

-- Ejecutarlo desde una terminal de Mysql 
-- Cuando sea la PRIMERA VEZ que se esta generando la base de datos, se debe enttrar como root en la computadora y accesar(root linux y mysql mismos) a "mysql"
		mysql -u root -p


-- Se debe accesar al directorio donde se encuentra el "script.sql" y ejecutar el comenado "mysql" desde una terminal
-- $ mysql -u nom-usr -p NombreBaseDatos < script.sql
-- Otra Forma :
	Es el usuario y contraseña que se definio cuando se creo el usuario (asignando permisos para crear, borrar tablas.)

--    mysql -u usuario -p NombreBaseDatos
--    source script.sql ó \. script.sql

			Borrar tabla: DROP TABLE <nombre Tabla>
			Borrar Base Datos : DROP DATABASE <nombre Base Datos>
			Borrar el contenido de la tabla : 
					truncate table nombre-tabla;
*/

/* 
Mostrar todos los usuarios 
  select user from mysql.user;

Para borrar un usuario: se tiene que ejecutar los dos comandos.
Para borrar un usuario para todos los hosts:
	drop user ventas-pos;

Para borrar un usuario en especifico
	delete from mysql.user where user = ‘ventas-pos’

Para borrar mas de un usuario en el host
	drop user ‘ventas-pos’@’localhost’;
	
	flush privileges;

BORRANDO EL CONTENIDO DE UNA TABLA EN MariaDB
	truncate table nombre-tabla;
Para mostrar los campos de una tabla:
	describe t_Responsivas;


*/

/* Tabla de Datos */
/* Se ocupa los 9 espacios, no se desperdicia espacio.*/
  /* CHAR(X) = cuando se define de algun tamaño pero no se utiliza, se despedicia espacio, por ejemplo
  CHAR(30), pero el valor de "title" es de 20, se desperdicio 60 espacios.
  VARCHAR(80) se adapta al tamaño del titulo.
  En la base de datos se puede guardar, videos, documentos en formato binario, pero creceria mucho.
  Se sube el video, documento, solo se graba la URL en el campo de la base de datos.
	
	estado INTEGER UNSIGNED DEFAULT 0,

	Tipos De Datos que maneja MySQL, MariaDb
	https://www.anerbarrena.com/tipos-dato-mysql-5024/

  */


 /* DROP DATABASE IF EXISTS bd_tienda_virtual; */

CREATE DATABASE IF NOT EXISTS bd_tienda_virtual;
 /* SET time_zone = 'America/Tijuana';  */

USE bd_tienda_virtual;


/*Solo se ejecuta la primera vez. 
CREATE USER 'usuario_tienda'@'localhost' IDENTIFIED BY 'Tienda_2022';
GRANT ALL on bd_tienda_virtual.* to 'usuario_tienda'  IDENTIFIED BY 'Tienda_2022';
*/

CREATE TABLE t_Personas
(
  id_persona SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  identificacion VARCHAR(30),
	nombres VARCHAR(80),
	apellidos VARCHAR(100),
	telefono SMALLINT,
	email_user VARCHAR(100),
	passwords VARCHAR(25),
	nit VARCHAR(20),
	nombrefiscal VARCHAR(80),
	direccionfiscal VARCHAR(100),
	toke VARCHAR(80),
	rolid SMALLINT UNSIGNED  NOT NULL,
	datecreated DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	estatus TINYINT DEFAULT 1,
	FOREIGN KEY(rolid) REFERENCES t_Rol(id_rol)
	ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE t_Rol
(
  id_rol SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  nombrerol VARCHAR(50),
	descripcion TEXT,
	estatus TINYINT DEFAULT 1
);

CREATE TABLE t_Modulos
(
  id_modulo SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  titulo VARCHAR(50),
	descripcion TEXT,
	estatus TINYINT DEFAULT 1	
);

CREATE TABLE t_Permisos
(
  id_permiso SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  rolid SMALLINT UNSIGNED NOT NULL,
	moduloid SMALLINT UNSIGNED NOT NULL,
	r TINYINT DEFAULT 0,
	w TINYINT DEFAULT 0,
	u TINYINT DEFAULT 0,
	d TINYINT DEFAULT 0,
	FOREIGN KEY(rolid) REFERENCES t_Rol(id_rol)
	ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY(moduloid) REFERENCES t_Modulos(id_modulo)
	ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE t_Categorias
(
  id_categoria SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR (100),
	descripcion TEXT,
	datecreated DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	estatus TINYINT DEFAULT 1	
);

CREATE TABLE t_Productos
(
  id_producto SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	categoriaid SMALLINT UNSIGNED NOT NULL,	
  codigo VARCHAR (30),
	nombre VARCHAR (100),
	descripcion TEXT,
	precio decimal(10,2) DEFAULT NULL,
	stock SMALLINT UNSIGNED,
	imagen VARCHAR(100),
	datecreated DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	estatus TINYINT DEFAULT 1,
	FOREIGN KEY(categoriaid) REFERENCES t_Categorias(id_categoria)
	ON DELETE RESTRICT ON UPDATE CASCADE
);


CREATE TABLE t_Pedidos
(
  id_pedido SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	personaid SMALLINT UNSIGNED NOT NULL,	
	fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	monto decimal(10,2) DEFAULT NULL,
	tipopagoid SMALLINT UNSIGNED,
	estatus TINYINT DEFAULT 1,
	FOREIGN KEY(personaid) REFERENCES t_Personas(id_persona)
	ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE t_Detalle_Pedidos
(
  id_detalle_pedido INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	pedidoid SMALLINT UNSIGNED NOT NULL,	
	productoid SMALLINT UNSIGNED NOT NULL,	
	cantidad SMALLINT UNSIGNED,
	precio decimal(10,2) DEFAULT NULL,		
	FOREIGN KEY(pedidoid) REFERENCES t_Pedidos(id_pedido)
	ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY(productoid) REFERENCES t_Productos(id_producto)
	ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE t_Detalle_Temp
(
  id_detalle_pedido SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	productoid SMALLINT UNSIGNED NOT NULL,	
	cantidad SMALLINT UNSIGNED,
	precio decimal(10,2) DEFAULT NULL,
	token VARCHAR(100),
	FOREIGN KEY(productoid) REFERENCES t_Productos(id_producto)
	ON DELETE RESTRICT ON UPDATE CASCADE
);


/*
CREATE TABLE t_Usuario
(
  id SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(50) DEFAULT NULL,
  edad SMALLINT UNSIGNED	 	
);
*/


/*
CREATE TABLE t_Periferico
(
  id_periferico SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(80) NOT NULL,  
  fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE t_Almacen
(
  id_almacen SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(80) NOT NULL  
);

CREATE TABLE t_Edo_epo
(
  id_edo_epo SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  descripcion VARCHAR(80) NOT NULL  
);

CREATE TABLE t_Marca
(
  id_marca SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  descripcion VARCHAR(45) NOT NULL  
);

CREATE TABLE t_Linea
(
  id_linea SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  descripcion VARCHAR(45) NOT NULL  
);

CREATE TABLE t_Modelo
(
  id_modelo SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  descripcion VARCHAR(45) NOT NULL  
);

CREATE TABLE t_Telefonia
(
  id_telefonia SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(50) NOT NULL
);

CREATE TABLE t_PlanTelefonia
(
  id_plan_tel SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(50) NOT NULL
);

CREATE TABLE t_Usuarios
(
  id_usuario SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(45) NOT NULL,
  usuario VARCHAR(45) NOT NULL,
  clave VARCHAR(80) NOT NULL,
  perfil VARCHAR(45) NOT NULL,
  vendedor VARCHAR(45) NULL,
  foto VARCHAR(100) NULL,
  estado TINYINT UNSIGNED DEFAULT 0,
  ultimo_login DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE t_Puesto
(
  id_puesto SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  descripcion VARCHAR(45) NOT NULL	
);

CREATE TABLE t_Ubicacion
(
  id_ubicacion SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  descripcion VARCHAR(45) NOT NULL	
);

CREATE TABLE t_Supervisor
(
  id_supervisor SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  descripcion VARCHAR(50) NOT NULL	
);

CREATE TABLE t_Depto
(
  id_depto SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  descripcion VARCHAR(50) NOT NULL	
);


CREATE TABLE t_Centro_Costos
(
  id_centro_costos SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	num_centro_costos VARCHAR(30) NOT NULL,
  descripcion VARCHAR(80) NOT NULL	
);

CREATE TABLE t_Empleados
(
  id_empleado SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,  
	id_ubicacion SMALLINT UNSIGNED NOT NULL,
	id_puesto SMALLINT UNSIGNED NOT NULL,
	id_supervisor SMALLINT UNSIGNED NOT NULL,
	id_depto SMALLINT UNSIGNED NOT NULL,
	id_centro_costos SMALLINT UNSIGNED NOT NULL,
  nombre VARCHAR(20) NOT NULL,
	apellidos VARCHAR(45) NOT NULL,
	ntid VARCHAR(20) NOT NULL,
	correo_electronico VARCHAR(50) NOT NULL,
	rol VARCHAR(25) NULL,
	foto VARCHAR(100) NOT NULL,	
	fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	sFOREIGN KEY(id_ubicacion) REFERENCES t_Ubicacion(id_ubicacion)
	ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY(id_puesto) REFERENCES t_Puesto(id_puesto)
	ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY(id_supervisor) REFERENCES t_Supervisor(id_supervisor)
	ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY(id_depto) REFERENCES t_Depto(id_depto)
	ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY(id_centro_costos) REFERENCES t_Centro_Costos(id_centro_costos) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE t_Productos
(
  id_producto SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,  
	id_almacen SMALLINT UNSIGNED NOT NULL,
	id_edo_epo SMALLINT UNSIGNED NOT NULL,
	id_marca SMALLINT UNSIGNED NOT NULL,
	id_modelo SMALLINT UNSIGNED NOT NULL,
	id_linea SMALLINT UNSIGNED NOT NULL,
	id_ubicacion SMALLINT UNSIGNED NOT NULL,
	id_periferico SMALLINT UNSIGNED NOT NULL,
	id_empleado SMALLINT UNSIGNED DEFAULT 1,
	id_telefonia SMALLINT UNSIGNED NOT NULL,
	id_plan_tel SMALLINT UNSIGNED NOT NULL,
	num_tel VARCHAR(25) NULL,
	cuenta VARCHAR(45) NULL,	
	direcc_mac_tel VARCHAR(20) NULL,
	imei_tel VARCHAR(30) NULL,
  nomenclatura VARCHAR(45) NULL,
	num_serie VARCHAR(45) NULL,
	imagen_producto VARCHAR(100) NOT NULL,
	stock SMALLINT UNSIGNED DEFAULT 0,
	precio_compra decimal(10,2) DEFAULT NULL,
	precio_venta decimal(10,2) DEFAULT NULL,
	cuantas_veces TINYINT DEFAULT NULL,
	asignado CHAR(1) DEFAULT 'N',	
	fecha_arribo DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	edo_tel VARCHAR(15) NULL,
	num_ip VARCHAR(20) NULL,
	comentarios TEXT NULL,
	asset VARCHAR(15) DEFAULT NULL,
	loftware VARCHAR(10) DEFAULT NULL,	
	estacion VARCHAR(50) DEFAULT NULL,
	npa VARCHAR(15) DEFAULT NULL,
	idf VARCHAR(5) DEFAULT NULL,
	patch_panel VARCHAR(5) DEFAULT NULL,
	puerto VARCHAR(5) DEFAULT NULL,
	funcion VARCHAR(20) DEFAULT NULL,
	jls VARCHAR(15) DEFAULT NULL,
	qdc VARCHAR(15) DEFAULT NULL,
	FOREIGN KEY(id_almacen) REFERENCES t_Almacen(id_almacen)
	ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY(id_empleado) REFERENCES t_Empleados(id_empleado)
	ON DELETE RESTRICT ON UPDATE CASCADE,	
	FOREIGN KEY(id_edo_epo) REFERENCES t_Edo_epo(id_edo_epo)
	ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY(id_marca) REFERENCES t_Marca(id_marca)
	ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY(id_modelo) REFERENCES t_Modelo(id_modelo)
	ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY(id_linea) REFERENCES t_Linea(id_linea)
	ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY(id_ubicacion) REFERENCES t_Ubicacion(id_ubicacion)
	ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY(id_periferico) REFERENCES t_Periferico(id_periferico)
	ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY(id_telefonia) REFERENCES t_Telefonia(id_telefonia)
	ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY(id_plan_tel) REFERENCES t_PlanTelefonia(id_plan_tel)
	ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE t_Responsivas
(
  id_responsiva SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,  
	id_empleado SMALLINT UNSIGNED NOT NULL,
	id_usuario SMALLINT UNSIGNED NOT NULL,
	id_almacen SMALLINT UNSIGNED NOT NULL,	
  activa CHAR(1) DEFAULT 'S' NOT NULL,
	num_folio SMALLINT UNSIGNED NOT NULL,
	modalidad_entrega VARCHAR(25) NOT NULL,	
	num_ticket VARCHAR(30) NULL,
	responsiva_firmada VARCHAR(100) NULL,
	comentario TEXT DEFAULT NULL,
	comentario_devolucion TEXT DEFAULT NULL,
	productos TEXT  NULL,
  impuesto decimal(10,2) DEFAULT NULL,
	neto decimal(10,2) DEFAULT NULL,
	total decimal(10,2) DEFAULT NULL,
	fecha_devolucion DATE DEFAULT NULL,
	fecha_asignado DATE DEFAULT NULL,
	FOREIGN KEY(id_empleado) REFERENCES t_Empleados(id_empleado)
	ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY(id_usuario) REFERENCES t_Usuarios(id_usuario)
	ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY(id_almacen) REFERENCES t_Almacen(id_almacen)
	ON DELETE RESTRICT ON UPDATE CASCADE	
);

CREATE TABLE t_Estatus
(
  id_estatus SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  descripcion VARCHAR(20) NOT NULL	
);

CREATE TABLE t_Categorias
(
  id_categoria SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  descripcion VARCHAR(40) NOT NULL	
);

CREATE TABLE t_Tareas
(	
  id_tarea SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,  
	id_estatus SMALLINT UNSIGNED NOT NULL,
	id_usuario SMALLINT UNSIGNED NOT NULL,
	id_empleado SMALLINT UNSIGNED NOT NULL,
	id_categoria SMALLINT UNSIGNED NOT NULL,
	id_ubicacion SMALLINT UNSIGNED NOT NULL,
	tareas varchar(120) NULL,
	ticket varchar(25) NULL,
	fecha DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
	comentarios TEXT NULL,
	FOREIGN KEY(id_estatus) REFERENCES t_Estatus(id_estatus)
	ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY(id_usuario) REFERENCES t_Usuarios(id_usuario)
	ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY(id_empleado) REFERENCES t_Empleados(id_empleado)
	ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY(id_categoria) REFERENCES t_Categorias(id_categoria)
	ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY(id_ubicacion) REFERENCES t_Ubicacion(id_ubicacion) ON DELETE RESTRICT ON UPDATE CASCADE
);
*/
