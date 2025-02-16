<?php

$Repit = false;

// Obtener la cadena de conexión desde las variables de entorno
$conn_string = getenv("DB_CONNECTION_STRING");

// Verificar si la variable de entorno está definida
if (!$conn_string) {
    die("Error: La variable de entorno DB_CONNECTION_STRING no está definida.");
}

// Conectar a PostgreSQL
$link = pg_connect($conn_string);

if (!$link) {
    die("Error en la conexión: " . pg_last_error());
}

// Configurar codificación de caracteres a UTF8
pg_set_client_encoding($link, "UTF8");

// Puedes eliminar este mensaje en producción
// echo "Conexión a PostgreSQL exitosa.";

?>
