<?php

$localhost = "localhost";
$usuario = "root";
$senha = "root";
$banco = "atp";

try{
    $pdo = new PDO("mysql:dbname=".$banco."; host=".$localhost, $usuario, $senha);
}catch(PDOException $e){
    echo "ERRO: ".$e->getMessage();
    exit;
}

?>