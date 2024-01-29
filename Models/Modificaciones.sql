
/*
	Tipos de datos de MariaDB
  https://www.anerbarrena.com/tipos-dato-mysql-5024/



-- Ejecutarlo desde una terminal de Mysql 
-- Cuando sea la PRIMERA VEZ que se esta generando la base de datos, se debe enttrar como root en la computadora y accesar a "mysql"
		mysql -u root -p

Para ejecutar el "script"
-- Ejecutarlo desde una terminal de Mysql 
-- Se debe accesar al directorio donde se encuentra el "script.sql" y ejecutar el comenado "mysql" desde una terminal


-- $ mysql -u nom-usr -p NombreBaseDatos < script.sql
-- Otra Forma : Es el usuario y contraseña que se definio cuando se creo el usuario (asignando permisos para crear, borrar tablas.)
--    mysql -u usuario -p NombreBaseDatos
--    source script.sql ó \. script.sql
*/


/*
-- Se debe accesar al directorio donde se encuentra el "script.sql" y ejecutar el comanado "mysql" desde una terminal
-- $ mysql -u nom-usr -p NombreBaseDatos < script.sql
-- Otra Forma 
--    mysql -u usuario -p NombreBaseDatos
--    source script.sql ó \. script.sql

			Borrar tabla: DROP TABLE <nombre Tabla>
			Borrar Base Datos : DROP DATABASE <nombre Base Datos>
			Borrar el contenido de la tabla :  truncate table nombre-tabla;
			Borrar un campo dela tabla. : ALTER TABLE t_Rol DROP status;
*/

/*
DROP DATABASE IF EXISTS bd_tienda_virtual;

CREATE DATABASE IF NOT EXISTS bd_tienda_virtual;
 SET time_zone = 'America/Tijuana';  

CREATE USER 'usuario_tienda'@'localhost' IDENTIFIED BY 'Tienda_2022';
GRANT ALL on bd_tienda_virtual.* to 'usuario_tienda'  IDENTIFIED BY 'Tienda_2022';

*/

/* Se  Ejecuta estas tablas por separada ya que tiene problemas para crearlas */
USE bd_responsivas2;

CREATE TABLE t_Personas
(	
  id_persona SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,  
	id_rol SMALLINT UNSIGNED NOT NULL,
	id_ubicacion SMALLINT UNSIGNED NOT NULL,
	id_puesto SMALLINT UNSIGNED NOT NULL,
	id_supervisor SMALLINT UNSIGNED NOT NULL,
	id_depto SMALLINT UNSIGNED NOT NULL,
	id_centro_costos SMALLINT UNSIGNED NOT NULL,
  ntid VARCHAR(20) NOT NULL,
	num_empleado VARCHAR(30) NOT NULL,
	nombre_completo VARCHAR(150) NOT NULL,	
	telefono VARCHAR(20) DEFAULT NULL,
	correo_electronico VARCHAR(100) DEFAULT NULL,
	passwords VARCHAR(90) DEFAULT NULL,
	toke VARCHAR(90) DEFAULT NULL,
	foto VARCHAR(150) DEFAULT NULL,
	estatus TINYINT DEFAULT 1,
	fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY(id_ubicacion) REFERENCES t_Ubicacion(id_ubicacion)
	ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY(id_rol) REFERENCES t_Rol(id_rol)
	ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY(id_puesto) REFERENCES t_Puesto(id_puesto)
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
	id_persona SMALLINT UNSIGNED NOT NULL,
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
	FOREIGN KEY(id_persona) REFERENCES t_Personas(id_persona)
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
	id_persona SMALLINT UNSIGNED NOT NULL,
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
	FOREIGN KEY(id_persona) REFERENCES t_Personas(id_persona)
	ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY(id_almacen) REFERENCES t_Almacen(id_almacen)
	ON DELETE RESTRICT ON UPDATE CASCADE	
);


CREATE TABLE t_Imagen
(
  id_imagen SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,  
	id_producto SMALLINT UNSIGNED  NOT NULL,
	img VARCHAR(100) DEFAULT NULL,
	FOREIGN KEY(id_producto) REFERENCES t_Productos(id_producto)
	ON DELETE RESTRICT ON UPDATE CASCADE
);


/*

CREATE TABLE t_Imagen
(
  id_imagen INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,  
	productoid INT UNSIGNED  NOT NULL,
	img VARCHAR(100),
	FOREIGN KEY(productoid) REFERENCES t_Productos(id_producto)
	ON DELETE RESTRICT ON UPDATE CASCADE
);


/* 
Cambiar el nombre de un campo. 

ALTER TABLE `t_Personas` CHANGE `toke` `token` VARCHAR(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;

*/

/*
ALTER TABLE t_Permisos DROP W;
ALTER TABLE t_Permisos ADD w TINYINT DEFAULT 0;
ALTER TABLE t_Permisos DROP U;
ALTER TABLE t_Permisos ADD u TINYINT DEFAULT 0;
*/


/*
ALTER TABLE t_Rol DROP status;
ALTER TABLE t_Rol ADD status TEXT DEFAULT 1;
*/