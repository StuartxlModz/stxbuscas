<?php

session_start();

if($_SESSION["expirado"] === "True"){
    header("Location: renovar.php");
    exit();     
}

if(empty($_SESSION["logado"])){
header("Location: ../../");
exit();
}

?>