<?php
session_start();

date_default_timezone_set('America/Sao_Paulo');

require_once("payments/conexao.php");
require_once("payments/manage.php");


function multiexplode($delimiters, $string) {
    $one = str_replace($delimiters, $delimiters[0], $string);
    $two = explode($delimiters[0], $one);
    return $two;
}

if(isset($_REQUEST['collection_id'])){
    $id = $_REQUEST['collection_id'];
  }else{
    $id = $_REQUEST['id'];
   }

$valor_pagamento = $_REQUEST["valor"];
$usuario = $_REQUEST["usuario"];
$senha = $_REQUEST["senha"];
$email = $_REQUEST["email"];

if($valor_pagamento === "Mensal"){
    $dias = "31";
}if($valor_pagamento === "Semanal"){
    $dias = "8";
}if($valor_pagamento === "Diario"){
    $dias = "2";
}

global $dias;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$id");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("content-type: application/json"));
$retorno = curl_exec($ch);

if(stripos($retorno, "Este pagamento já foi realizado")){

$json = ["success" => true, "message" => "Aprovado"];
echo json_encode($json);

$sql = "INSERT INTO usuarios (id, usuario, senha, email, dias, data_acesso, nivel) VALUES (' ', '$usuario', '$senha', '$email' ,ADDDATE(CURRENT_DATE, INTERVAL $dias DAY), NOW(), '0')";
$result = mysqli_query($conexao, $sql);

}else if(stripos($retorno, "Como pagar")){
    $json = ["success" => false, "message" => "Pendente"];
    echo json_encode($json);
    exit();
}else{
    $json = ["success" => false, "message" => "Error"];
    echo json_encode($json);
}

?>