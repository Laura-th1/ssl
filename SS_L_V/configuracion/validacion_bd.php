<?php
// header('Content-Type: application/json');  
include_once("../includes/conexiones/Base_Datos/conexion.php");


CreacionTablasBD();
MigracionDatosBD();
function MigracionDatosBD()
{

    $con                        =                   conectar();
    $mensaje                    =                   "";
    $password                    =                   password_hash('admin1', PASSWORD_BCRYPT);

    $creacion_usu_admin = "INSERT INTO `usuarios` (`id`, `tipo_documento_id`, `numero_documento`, `nombre`, `apellido`, `fecha_nacimiento`, `sexo_id`, `rol_id`, `correo`, `foto`, `usuario`, `password`, `telefono`, `estado`, `usuario_create`, `usuario_act`, `fecha_create`, `fecha_act`) 
                            VALUES
                                (1, 1, '1003568870', 'admin1', 'Admin', '2003-01-15', 1, 1, 'laut15@outlook.com', '../../../includes/img/usuarios/ADMIN/Logo_1.jpg', 'ADMIN', '".$password."', '3006550835', 1, '1', NULL, '2024-12-04 03:54:07', '2024-12-04 03:54:07');";
    $data                 =               $con->query($creacion_usu_admin);

   
}
function CreacionTablasBD() 
{
    $con                        =                   conectar();
    $mensaje                    =                   "";

    $creacion_bd_tp_doc = "CREATE TABLE tp_documentos (
                                id                  INT AUTO_INCREMENT PRIMARY KEY,
                                abreviatura         VARCHAR(10) NOT NULL,
                                descripcion         VARCHAR(255) NOT NULL,
                                estado              TINYINT NOT NULL DEFAULT 1,
                                usuario_create      VARCHAR(50) NOT NULL,
                                usuario_act         VARCHAR(50),
                                fecha_create        TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                fecha_act           TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                            );";
    $data                 =               $con->query($creacion_bd_tp_doc);

    $creacion_bd_tp_titulacion = "CREATE TABLE tp_titulacion (
                                id                      INT AUTO_INCREMENT PRIMARY KEY,
                                descripcion             VARCHAR(255) NOT NULL,
                                estado                  TINYINT NOT NULL DEFAULT 1,
                                usuario_create          VARCHAR(50) NOT NULL,
                                usuario_act             VARCHAR(50),
                                fecha_create            TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                fecha_act               TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                            );";
    $data                 =               $con->query($creacion_bd_tp_titulacion);

    $creacion_bd_sexos = "CREATE TABLE sexos (
                                id                      INT AUTO_INCREMENT PRIMARY KEY,
                                descripcion             VARCHAR(255) NOT NULL,
                                estado                  TINYINT NOT NULL DEFAULT 1,
                                usuario_create          VARCHAR(50) NOT NULL,
                                usuario_act             VARCHAR(50),
                                fecha_create            TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                fecha_act               TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                            );";
    $data                 =               $con->query($creacion_bd_sexos);

    $creacion_bd_titulaciones = "CREATE TABLE titulaciones (
                                        id                      INT AUTO_INCREMENT PRIMARY KEY,
                                        descripcion             VARCHAR(255) NOT NULL,
                                        tipo_titulacion_id      INT NOT NULL,
                                        estado                  TINYINT NOT NULL DEFAULT 1,
                                        usuario_create          VARCHAR(50) NOT NULL,
                                        usuario_act             VARCHAR(50),
                                        fecha_create            TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                        fecha_act               TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                                    );";
    $data                 =               $con->query($creacion_bd_titulaciones);


    $creacion_bd_bloques = "CREATE TABLE Bloques (
                                        id                      INT AUTO_INCREMENT PRIMARY KEY,
                                        descripcion             VARCHAR(255) NOT NULL,
                                        id_departamento         INT NOT NULL,
                                        id_municipio            INT NOT NULL,
                                        estado                  TINYINT NOT NULL DEFAULT 1,
                                        usuario_create          VARCHAR(50) NOT NULL,
                                        usuario_act             VARCHAR(50),
                                        fecha_create            TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                        fecha_act               TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                                    );";
    $data                 =               $con->query($creacion_bd_bloques);


    $creacion_bd_roles = "CREATE TABLE roles (
                                    id                      INT AUTO_INCREMENT PRIMARY KEY,
                                    descripcion             VARCHAR(255) NOT NULL,
                                    estado                  TINYINT NOT NULL DEFAULT 1,
                                    usuario_create          VARCHAR(50) NOT NULL,
                                    usuario_act             VARCHAR(50),
                                    fecha_create            TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                    fecha_act               TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                                );";
    $data                 =               $con->query($creacion_bd_roles);

    // $creacion_bd_departamentos = "CREATE TABLE departamentos (
    //                                     id                      INT AUTO_INCREMENT PRIMARY KEY,
    //                                     descripcion             VARCHAR(255) NOT NULL,
    //                                     estado                  TINYINT NOT NULL DEFAULT 1,
    //                                     usuario_create          VARCHAR(50) NOT NULL,
    //                                     usuario_act             VARCHAR(50),
    //                                     fecha_create            TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    //                                     fecha_act               TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    //                                 );";
    // $data                 =               $con->query($creacion_bd_departamentos);

    // $creacion_bd_municipios = "CREATE TABLE municipios (
    //                                     id                      INT AUTO_INCREMENT PRIMARY KEY,
    //                                     id_departamento         INT NOT NULL,
    //                                     descripcion             VARCHAR(255) NOT NULL,
    //                                     estado                  TINYINT NOT NULL DEFAULT 1,
    //                                     usuario_create          VARCHAR(50) NOT NULL,
    //                                     usuario_act             VARCHAR(50),
    //                                     fecha_create            TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    //                                     fecha_act               TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    //                                 );";
    // $data                 =               $con->query($creacion_bd_municipios);

    $creacion_bd_productos = "CREATE TABLE productos (
                                id                      INT AUTO_INCREMENT PRIMARY KEY,
                                descripcion             VARCHAR(255) NOT NULL,
                                observacion             TEXT,
                                estado                  TINYINT NOT NULL DEFAULT 1,
                                usuario_create          VARCHAR(50) NOT NULL,
                                usuario_act             VARCHAR(50),
                                fecha_create            TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                fecha_act               TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                            );";
    $data                 =               $con->query($creacion_bd_productos);

    $creacion_bd_ambientes = "CREATE TABLE ambientes (
                                    id                      INT AUTO_INCREMENT PRIMARY KEY,
                                    Bloque_id                 INT NOT NULL,
                                    descripcion             VARCHAR(255) NOT NULL,
                                    observacion             TEXT,
                                    estado                  TINYINT NOT NULL DEFAULT 1,
                                    usuario_create          VARCHAR(50) NOT NULL,
                                    usuario_act             VARCHAR(50),
                                    fecha_create            TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                    fecha_act               TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                                );";
    $data                 =               $con->query($creacion_bd_ambientes);


    $creacion_bd_inventarios = "CREATE TABLE inventarios (
                                    id                      INT AUTO_INCREMENT PRIMARY KEY,
                                    Bloque_id                 INT NOT NULL,
                                    nombre                  VARCHAR(255) NOT NULL,
                                    observacion             TEXT,
                                    estado                  TINYINT NOT NULL DEFAULT 1,
                                    usuario_create          VARCHAR(50) NOT NULL,
                                    usuario_act             VARCHAR(50),
                                    fecha_create            TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                    fecha_act               TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                                );";
    $data                 =               $con->query($creacion_bd_inventarios);

    $creacion_bd_data_inventario = "CREATE TABLE datos_inventario (
                                    id                      INT AUTO_INCREMENT PRIMARY KEY,
                                    inventario_id           INT NOT NULL,
                                    producto_id             INT NOT NULL,
                                    cantidad                INT,
                                    observacion             TEXT,
                                    estado                  TINYINT NOT NULL DEFAULT 1,
                                    usuario_create          VARCHAR(50) NOT NULL,
                                    usuario_act             VARCHAR(50),
                                    fecha_create            TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                    fecha_act               TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                                );";
    $data                 =               $con->query($creacion_bd_data_inventario);

    $creacion_bd_agenda_ambientes = "CREATE TABLE agenda_ambientes (
                                        id                      INT AUTO_INCREMENT PRIMARY KEY,
                                        fecha                   DATE,
                                        hora_ini                TIME,
                                        hora_fin                TIME,
                                        Bloque_id                 INT NOT NULL,
                                        ambiente_id             INT NOT NULL,
                                        titulacion_id           INT NOT NULL,
                                        estado                  TINYINT NOT NULL DEFAULT 1,
                                        usuario_create          VARCHAR(50) NOT NULL,
                                        usuario_act             VARCHAR(50),
                                        fecha_create            TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                        fecha_act               TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                                    );";
    $data                 =               $con->query($creacion_bd_agenda_ambientes);

    $creacion_bd_usuarios = "CREATE TABLE usuarios (
                                                    id                          INT AUTO_INCREMENT PRIMARY KEY,
                                                    tipo_documento_id           INT NOT NULL,
                                                    numero_documento            VARCHAR(50) NOT NULL,
                                                    nombre                      VARCHAR(50) NOT NULL,
                                                    apellido                    VARCHAR(50) NOT NULL,
                                                    fecha_nacimiento            DATE NOT NULL,
                                                    sexo_id                     INT NOT NULL,
                                                    rol_id                      INT NOT NULL,
                                                    correo                      VARCHAR(100) NOT NULL,
                                                    foto                        TEXT NOT NULL,
                                                    usuario                     VARCHAR(50) NOT NULL,
                                                    password                    VARCHAR(255) NOT NULL,
                                                    telefono                    VARCHAR(10),
                                                    estado                      TINYINT NOT NULL DEFAULT 1,
                                                    usuario_create              VARCHAR(50) NOT NULL,
                                                    usuario_act                 VARCHAR(50),
                                                    fecha_create                TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                                    fecha_act                   TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                                                );";
    $data                 =               $con->query($creacion_bd_usuarios);

}

function EliminarBD() {}
