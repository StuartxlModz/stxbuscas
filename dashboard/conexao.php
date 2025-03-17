<?php

$hostname = "https://auth-db1436.hstgr.io/";
$bancodedados = "usuarios";
$usuario = "u519859256_kaique";
$senha = "Atlas6194";

$mysqli = new mysqli($hostname, $usuario, $senha, $bancodedados);
if ($mysql->connect_errno) {
    echo "falha ao conectar: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}