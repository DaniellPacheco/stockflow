<?php

require_once 'db.php';
session_start();

if(
    isset($_POST['email']) && !empty($_POST['email']) 
    && 
    isset($_POST['senha']) && !empty($_POST['senha'])
    ){
    
    $email = addslashes($_POST['email']);
    $senha = addslashes($_POST['senha']);

    $sql = "SELECT * FROM usuario WHERE email = :email AND senha = :senha";
    $sql = $pdo->prepare($sql);
    $sql->bindValue("email", $email);
    $sql->bindValue("senha", md5($senha));
    $sql->execute();

    // Validando se usuário existe
    if($sql->rowCount() > 0) {
        $dado = $sql->fetch();
        $_SESSION['idUser'] = $dado['id_usuario'];
        if(isset($_SESSION['idUser'])) {
            header("Location: dashboard.php");
        } else {
            header("Location: index.php");    
        }
    } else {
        header("Location: index.php");
    } 
    
} else {
    header("Location: index.php");
}



?>