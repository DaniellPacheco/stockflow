<?php

require 'verifica_login.php';
require 'db.php';


$id = $_GET['id'];

$sql = 'DELETE FROM item WHERE id_item = :id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $id);
if($stmt->execute()) {
    header("Location: itens.php");
}

?>