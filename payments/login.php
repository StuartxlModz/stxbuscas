<?php

include("conexao.php");

session_start();

$usuario = mysqli_real_escape_string($conexao, $_POST['usuario']);
$senha = mysqli_real_escape_string($conexao, $_POST['senha']);

if(empty($usuario) and empty($senha)){
    $json = array("success" => false, "message" => "Preencha os Dados.");
    echo json_encode($json);
    exit();
}


$sql = "SELECT * FROM usuarios where usuario = '$usuario' and senha = '$senha'";
$execute = mysqli_query($conexao, $sql);

if(mysqli_num_rows($execute) > 0){
    $array = mysqli_fetch_assoc($execute);

    $dias1 = $array["dias"];
    $dias2 = $array["data_acesso"];

    $data_inicial = date("Y-m-d");
    $dias2 = date($dias1);

    $diferenca = strtotime($dias2) - strtotime($data_inicial);

    $dias = floor($diferenca / (60 * 60 * 24));

    if($dias > 0){


        if(!isset($_SESSION)) {
        session_start();
        }
    
        $_SESSION["logado"] = true;
        $_SESSION["usuario"] = $array["usuario"];
        $_SESSION["dias"] = $array["dias"];
        $_SESSION["id"] = $array["id"];
        $_SESSION["nivel"] = $array["nivel"];
    
    
    
        $json = array("success" => true);
        echo json_encode($json);
    }

    elseif($dias == "0"){
        $_SESSION["logado"] = true;
        $_SESSION["dias"] = $array["dias"];
        $_SESSION["usuario"] = $array["usuario"];

        $json = array("renovar" => true, "message" => "Seu usuário Expirou");
        echo json_encode($json);
    }

    elseif($dias < "-0"){
        $_SESSION["logado"] = true;
        $_SESSION["expirado"] = true;
        $_SESSION["dias"] = $array["dias"];
        $_SESSION["usuario"] = $array["usuario"];

        $json = array("renovar" => true, "message" => "Seu usuário Expirou");
        echo json_encode($json);
    }

}

else{
    $json = array("success" => false, "message" => "Usuário ou Senha incorretos");
    echo json_encode($json);
}

?>