<?php
require 'verifica_login.php';
require 'db.php';

$id = $_GET['id'];

$sql = 'DELETE FROM usuarios WHERE id_usuario = :id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $id);
if($stmt->execute()) {
    header("Location: usuarios.php");
}

?>