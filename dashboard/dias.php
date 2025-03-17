<?php

error_reporting(0);
include('protect.php');

include('../payments/conexao.php');
session_start();

$usuario = mysqli_real_escape_string($conexao, $_SESSION['usuario']);

$sql = mysqli_query($conexao, "SELECT * FROM usuarios WHERE usuario = '$usuario'");
$buscar = mysqli_fetch_assoc($sql);

$dias1 = $buscar["dias"];
$dias2 = $buscar["data_acesso"];

$data_inicial = date("Y-m-d");
$dias2 = date("$dias1");

$diferenca = strtotime($dias2) - strtotime($data_inicial);

$dias = floor($diferenca / (60 * 60 * 24));

if($dias < 1){
    $json = array("success" => false, "message" => "Usuário Expirou");
    echo json_encode($json);
}

elseif($dias < "-1"){
    $json = array("success" => false, "message" => "Usuário Expirou");
    echo json_encode($json);
}


?>