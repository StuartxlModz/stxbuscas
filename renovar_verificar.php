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

$userid = $_SESSION["usuario"];

$valor_pagamento = $_REQUEST["valor"];

if($valor_pagamento === "Mensal"){
    $dias = "31";
}if($valor_pagamento === "Semanal"){
    $dias = "7";
}if($valor_pagamento === "Diario"){
    $dias = "1";
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

mysqli_query($conexao, "UPDATE usuarios SET dias = ADDDATE(CURRENT_DATE, INTERVAL $dias DAY) WHERE usuario = '$userid'");

}else if(stripos($retorno, "Como pagar")){
    $json = ["success" => false, "message" => "Pendente"];
    echo json_encode($json);
    exit();
}else{
    $json = ["success" => false, "message" => "Error"];
    echo json_encode($json);
}

?>