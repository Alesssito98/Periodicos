<?php

$Repit = false;

$conn_string = "postgres://default:DlC2mcJFxIr4@ep-yellow-dust-a7l7gm6q.ap-southeast-2.aws.neon.tech:5432/verceldb?sslmode=require";

$link = pg_connect($conn_string);

if (!$link) {
    die("Error en la conexión: " . pg_last_error());
}

pg_set_client_encoding($link, "UTF8");

echo "Conexión a PostgreSQL exitosa.";

?>
