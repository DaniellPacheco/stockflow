<?php
require 'verifica_login.php';
require 'db.php';

$id = $_GET['id'];
$hoje = date('Y/m/d');


$sql = 'SELECT * FROM emprestado WHERE id_emprestado = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $id);
$stmt->execute();
$emprestado = $stmt->fetch(PDO::FETCH_OBJ);

if(empty($emprestado->dataEntrega)) {

    // Atualizando data de entrega
    $sql = 'UPDATE emprestado SET dataEntrega = :dataEntrega WHERE id_emprestado = :id';
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":dataEntrega", $hoje);
    $stmt->bindValue(":id", $id);
    $stmt->execute();

    $sql = 'SELECT * FROM item WHERE id_item = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":id", $emprestado->id_item);
    $stmt->execute();
    $item = $stmt->fetch(PDO::FETCH_OBJ);

    
    // Voltando produtos para o estoque
    $subtracao = $item->quantidadeEmprestada - $emprestado->quantidade;

    var_dump($subtracao);
    
    $sql = 'UPDATE item SET quantidadeEmprestada = :quantidadeEmprestada WHERE id_item = :id';
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":quantidadeEmprestada", $subtracao);
    $stmt->bindValue(":id", $item->id_item);
    $stmt->execute();

    header("Location: dashboard.php");

 } else {
     header("Location: dashboard.php");
}



