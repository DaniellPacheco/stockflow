<?php

require 'verifica_login.php';
require 'db.php';

$id = $_GET['id'];

$sql = 'DELETE FROM emprestado WHERE id_emprestado = :id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $id);
if($stmt->execute()) {
    header("Location: dashboard.php");
}

?>