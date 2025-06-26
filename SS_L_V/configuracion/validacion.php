<?php
// header('Content-Type: application/json');  
include_once("/includes/conexiones/Base_Datos/conexion.php");


CreacionTablasBD();
MigracionDatosBD();
function MigracionDatosBD()
{

    $con                        =                   conectar();
    $mensaje                    =                   "";
    $password                    =                   password_hash('Admin', PASSWORD_BCRYPT);

    $creacion_usu_admin = "INSERT INTO `usuarios` (`id`, `tipo_documento_id`, `numero_documento`, `nombre`, `apellido`, `fecha_nacimiento`, `sexo_id`, `rol_id`, `correo`, `foto`, `usuario`, `password`, `telefono`, `estado`, `usuario_create`, `usuario_act`, `fecha_create`, `fecha_act`, `token`, `token_expired`) 
                            VALUES
                                (47, 1, '0000000000', 'ADMINISTRADOR', '1', '2000-01-01', 1, 1, 'sena.stock3@gmail.com', '../../../includes/img/usuarios/ADMIN/logo-sena-verde-complementario-png-2022.png', 'ADMIN', '".$password."', NULL, 1, '1', NULL, '2025-03-15 03:54:07', '2025-03-15 02:00:00', ,'0000-00-00 00:00:00');";
    $data                 =               $con->query($creacion_usu_admin);

    $datos_bd_tp_doc = "INSERT INTO tp_documentos (abreviatura, descripcion, estado, usuario_create, usuario_act, fecha_create, fecha_act)
                            VALUES
                            ('CC', 'Cédula de Ciudadanía', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                            ('P', 'Pasaporte', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                            ('TI', 'Tarjeta de Identidad', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                            ('LC', 'Licencia de Conducción', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                            ('CE', 'Cédula de Extranjería', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                            ('DNI', 'Documento Nacional de Identidad', 1, 1, NULL, CURRENT_TIMESTAMP, NULL);";
    $data                 =               $con->query($datos_bd_tp_doc);

    $datos_bd_tp_titulacion = "INSERT INTO tp_titulacion (descripcion, estado, usuario_create, usuario_act, fecha_create, fecha_act)
                            VALUES
                                ('Tecnico', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Cursos Cortos', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Tecnologo', 1, 1, NULL, CURRENT_TIMESTAMP, NULL);";
    $data                 =               $con->query($datos_bd_tp_titulacion);

    $datos_bd_sexos = "INSERT INTO sexos (descripcion, estado, usuario_create, usuario_act, fecha_create, fecha_act)
                            VALUES
                                ('Masculino', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Femenino', 1, 1, NULL, CURRENT_TIMESTAMP, NULL);";
    $data                 =               $con->query($datos_bd_sexos);

    $datos_bd_roles = "INSERT INTO roles (descripcion, estado, usuario_create, usuario_act, fecha_create, fecha_act) VALUES
                            ('Administrador', 1, 1, NULL, '2025-03-15', NULL),
                            ('Apoyo Técnologico', 1, 1, NULL, '2025-03-15', NULL),
                            ('Cuentadante', 1, 1, NULL, '2025-03-15', NULL),
                            ('Coordinador', 1, 1, NULL, '2025-03-15', NULL);";
    
    $data                 =               $con->query($datos_bd_roles);

    $datos_bd_titulaciones = "INSERT INTO titulaciones (descripcion, tipo_titulacion_id, estado, usuario_create, usuario_act, fecha_create, fecha_act)
                            VALUES
                                ('Técnico en Sistemas', 1, 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Curso en Programación', 2, 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Tecnólogo en Informática', 3, 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Carrera en Ingeniería', 4, 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Técnico en Redes', 1, 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Curso en Bases de Datos', 2, 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Tecnólogo en Redes', 3, 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Carrera en Ciencias', 4, 1, 1, NULL, CURRENT_TIMESTAMP, NULL);";

    $data                 =               $con->query($datos_bd_titulaciones);


    $datos_bd_productos = "INSERT INTO productos (descripcion, observacion, estado, usuario_create, usuario_act, fecha_create, fecha_act)
                            VALUES
                                ('Monitor de PC', '24 pulgadas, marca Dell', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Portátil', 'Lenovo ThinkPad', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Proyector', 'BenQ, alta resolución', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Silla', 'Ergonómica, marca Herman Miller', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Pupitre', 'Madera, ajustable', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Tablero', 'Acrílico, 2x3 metros', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Videovim', 'EPSON, Full HD', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Pipetas', 'Set de 10, marca Gilson', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Impresora', 'HP LaserJet Pro', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Router', 'Cisco, alta velocidad', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Escáner', 'Canon, alta resolución', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Microscopio', 'Óptico, marca Olympus', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Grabadora de Voz', 'Sony, digital', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Cámara de Video', 'Full HD, Canon', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Servidor', 'Dell PowerEdge', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Teclado', 'Logitech, mecánico', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Mouse', 'Ergonómico, inalámbrico', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Smartphone', 'Samsung Galaxy', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Tablet', 'iPad, Apple', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Modem', 'Netgear, WiFi 6', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Webcam', 'Logitech, Full HD', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Parlantes', 'Bose, Bluetooth', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Auriculares', 'Sony, Noise Cancelling', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Cargador', 'USB-C, rápida carga', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Disco Duro', 'Externos, 2TB, marca Seagate', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Memoria USB', '64GB, SanDisk', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Refrigerador', 'LG, doble puerta', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Microondas', 'Panasonic, inversor', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Lavadora', 'Samsung, carga frontal', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Horno Eléctrico', 'Oster, convectión', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Aire Acondicionado', 'Daikin, inverter', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Termostato', 'Nest, inteligente', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Impresora 3D', 'Creality, Ender 3', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Cámara DSLR', 'Nikon, D3500', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Proyector Portátil', 'Anker, Nebula', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Bicicleta Eléctrica', 'Giant, Road E+', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Scooter Eléctrico', 'Xiaomi, Mi Scooter Pro', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Dron', 'DJI, Mavic Mini', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Sierra Eléctrica', 'Bosch, cortadora', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Taladro', 'Dewalt, inalámbrico', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Aspiradora', 'Dyson, V11', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Cortadora de Césped', 'Honda, gasolina', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Impresora Multifuncional', 'Brother, láser', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Estabilizador de Cámara', 'Zhiyun, Weebill S', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Batería Externa', 'Anker, 20000mAh', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Enrutador Mesh', 'Google, Nest WiFi', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Borrador Interactivo', 'Wacom, digital', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Pluma 3D', 'Scribbler, 3D Pen', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Scanner de Mano', 'Xerox, portátil', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Matriz de Impresión', 'Epson, EcoTank', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Módem de Fibra', 'TP-Link, alta velocidad', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Radio Transmisor', 'Motorola, profesional', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Detector de Metales', 'Garrett, AT Pro', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Adaptador WiFi', 'TP-Link, USB', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Interruptor Inteligente', 'Sonoff, WiFi', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Sensor de Movimiento', 'Philips, Hue', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                ('Termómetro Infrarrojo', 'Fluke, digital', 1, 1, NULL, CURRENT_TIMESTAMP, NULL);";

    $data = $con->query($datos_bd_productos);

    $datos_bd_ambientes = "INSERT INTO ambientes (sede_id, descripcion, observacion, estado, usuario_create, usuario_act, fecha_create, fecha_act)
                            VALUES
                                (1, 'Laboratorio de Física', 'Equipado con instrumentos de medición', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (2, 'Aula de Matemáticas', 'Pizarras interactivas y proyectores', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (3, 'Laboratorio de Química', 'Equipos para experimentos químicos', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (4, 'Sala de Computación', 'Ordenadores modernos y software educativo', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (5, 'Biblioteca', 'Gran colección de libros y recursos digitales', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (6, 'Laboratorio de Biología', 'Microscopios y muestras biológicas', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (7, 'Taller de Robótica', 'Kits de robótica y componentes electrónicos', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (8, 'Aula de Arte', 'Materiales para pintura y escultura', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (9, 'Gimnasio', 'Equipos de entrenamiento y área de deportes', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (10, 'Auditorio', 'Asientos cómodos y equipo de sonido', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (11, 'Sala de Música', 'Instrumentos musicales y equipo de grabación', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (12, 'Laboratorio de Idiomas', 'Software de aprendizaje de idiomas', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (13, 'Cafetería', 'Mesas, sillas y área de autoservicio', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (14, 'Sala de Estudio', 'Mesas de trabajo y sillas', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (15, 'Oficina de Consejería', 'Espacio para atención a estudiantes', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (16, 'Sala de Conferencias', 'Equipo de videoconferencia y proyector', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (17, 'Laboratorio de Electrónica', 'Componentes electrónicos y estaciones de trabajo', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (18, 'Taller de Carpintería', 'Herramientas y materiales de carpintería', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (19, 'Aula de Ciencias Sociales', 'Pizarras y mapas didácticos', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (20, 'Aula de Educación Física', 'Equipo para actividades deportivas', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (21, 'Sala de Reuniones', 'Mesa de reuniones y sillas', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (22, 'Laboratorio de Física Aplicada', 'Equipos de experimentación avanzada', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (23, 'Aula de Literatura', 'Bibliografía extensa y recursos digitales', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (24, 'Taller de Cerámica', 'Tornos y hornos para cerámica', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (25, 'Sala de Proyectos', 'Mesas de trabajo y equipo multimedia', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (26, 'Laboratorio de Computación Avanzada', 'Supercomputadoras y software especializado', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (27, 'Aula de Física Cuántica', 'Material didáctico avanzado', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (28, 'Taller de Automoción', 'Vehículos y herramientas de mecánica', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (29, 'Aula de Biotecnología', 'Equipos de bioingeniería', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (30, 'Laboratorio de Inteligencia Artificial', 'Servidores y software de IA', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (31, 'Taller de Soldadura', 'Equipos de soldadura y seguridad', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (32, 'Aula de Ingeniería Civil', 'Maquetas y software de simulación', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (33, 'Taller de Electrónica Digital', 'Componentes y estaciones de trabajo', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (34, 'Aula de Análisis de Datos', 'Computadoras y software estadístico', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (35, 'Laboratorio de Materiales', 'Equipos para ensayo de materiales', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (36, 'Taller de Diseño Gráfico', 'Computadoras y software de diseño', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (37, 'Aula de Comunicación Social', 'Equipos de grabación y edición', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (38, 'Taller de Textiles', 'Máquinas de coser y telas', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (39, 'Laboratorio de Ciencias de la Tierra', 'Equipos de geología y geografía', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (40, 'Sala de Innovación', 'Equipos multimedia y mesas de trabajo', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (41, 'Taller de Manufactura', 'Maquinaria y herramientas industriales', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (42, 'Laboratorio de Biomedicina', 'Equipos de investigación biomédica', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (43, 'Aula de Programación', 'Computadoras y entornos de desarrollo', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (44, 'Taller de Energías Renovables', 'Paneles solares y equipos eólicos', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (45, 'Aula de Física Nuclear', 'Equipos de física avanzada', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (46, 'Sala de Robótica Avanzada', 'Robots y componentes de alta tecnología', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (47, 'Laboratorio de Química Orgánica', 'Equipos de síntesis y análisis', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (48, 'Taller de Ingeniería Mecánica', 'Máquinas y herramientas de precisión', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (49, 'Aula de Economía', 'Pizarras y material didáctico', 1, 1, NULL, CURRENT_TIMESTAMP, NULL),
                                (50, 'Taller de Arquitectura', 'Maquetas y software de diseño', 1, 1, NULL, CURRENT_TIMESTAMP, NULL);";

    $data = $con->query($datos_bd_ambientes);


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


    $creacion_bd_sedes = "CREATE TABLE bloques (
                                        id                      INT AUTO_INCREMENT PRIMARY KEY,
                                        descripcion             VARCHAR(255) NOT NULL, 
                                        departamento_id         INT NOT NULL,
                                        municipio_id            INT NOT NULL,
                                        estado                  TINYINT NOT NULL DEFAULT 1,
                                        usuario_create          VARCHAR(50) NOT NULL,
                                        usuario_act             VARCHAR(50),
                                        fecha_create            TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                        fecha_act               TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                                    );";
    $data                 =               $con->query($creacion_bd_sedes);


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
                                    bloque_id                 INT NOT NULL,
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
                                    bloque_id                 INT NOT NULL,
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
                                        sede_id                 INT NOT NULL,
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

function ValidacionBD() {}

function EliminarBD() {}