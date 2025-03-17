<?php
session_start();
require_once("../payments/conexao.php");

$nova_senha = mysqli_real_escape_string($conexao, $_POST['senha']);
$id = trim($_SESSION["id"]);

if(empty($nova_senha)){
$json = ["success" => false, "message" => "Informe uma Senha"];
echo json_encode($json);
exit();
}

$alterar = mysqli_query($conexao, "UPDATE usuarios SET senha = $nova_senha WHERE id = '$id'");

if($alterar){
$json = ["success" => true, "message" => "Senha Alterada"];
echo json_encode($json);
exit();
}