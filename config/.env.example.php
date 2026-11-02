<?php

/* COPIA ESTE ARCHIVO, RENÓMBRALO COMO .env.php Y CAMBIA LOS DATOS NECESARIOS */

// Credenciales de acceso a la base de datos
define('DB_HOST', 'tu_host');
define('DB_NAME', 'tu_BBDD');
define('DB_USER', 'tu_usuario');
define('DB_PASS', 'tu_contraseña');
define('DB_PORT', 3306); // Puerto por defecto en la mayoría de servidores. Cambiarlo si se utiliza otro

// Se define el entorno
define('PROJECT_ENVIRONMENT', 'development'); // 'development' o 'production'
