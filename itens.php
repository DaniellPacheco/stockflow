<?php
require 'verifica_login.php';
require 'header.php'; 
require 'db.php';

$sql = "SELECT * FROM item";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$itens = $stmt->fetchAll(PDO::FETCH_OBJ);

?>

<div class="d-grid gap-2 d-md-flex justify-content-center mt-4">
    <a href="cadastrar_item.php" class="btn btn-warning btn-lg mr-2 " role="button">
        <img style="width: 25px; margin-right: 5px;" src="./icones/add.svg" alt="Icone Cadastrar Item"> Cadastrar Produto
    </a>
</div>

<table class="table mt-2">
    <thead class="thead-dark">
        <tr class="text-center">
            <th scope="col" class="align-middle">ID</th>
            <th scope="col" class="align-middle">Produto</th>
            <th scope="col" class="align-middle">Descrição</th>
            <th scope="col" class="align-middle">Estoque</th>
            <th scope="col" class="align-middle">Emprestado</th>
            <th scope="col" class="align-middle">Disponível</th>
            <th scope="col" class="align-middle">Editar</th>
            <th scope="col" class="align-middle">Deletar</th>
        </tr>
    </thead>
    <tbody>

    <?php foreach($itens as $item): ?>

        <tr >
            <td class="col-0 text-center"><?php echo $item->id_item; ?></td> 
            <td class="col-4"><strong><?php echo $item->titulo; ?></strong></td> 
            <td class="col-2"><?php echo $item->descricao; ?></td>
            <td class="col-1 text-center"><?php echo $item->quantidadeInicial; ?></td> 
            <td class="col-1 text-center"><?php echo $item->quantidadeEmprestada; ?></td> 
            <td class="col-1 text-center"><?php echo $item->quantidadeInicial - $item->quantidadeEmprestada; ?></td> 
            <td class="col-1 text-center">
                <a href="editar_item.php?id=<?php echo $item->id_item; ?>" class="btn btn-warning btn-sm mr-2" role="button">
                    <img style="width: 20px;" class="text-warning" src="./icones/edit.svg" alt="Botão Editar">    
                </a> 
            </td>
            <td class="col-1 text-center">
                <a onclick="return confirm('Você tem certeza disso?')" href="deletar_item.php?id=<?php echo $item->id_item; ?>" class="btn btn-danger btn-sm mr-2 text-white" role="button">
                    <img style="width: 20px;" src="./icones/delete.svg" alt="Botão Deletar">
                </a>
            </td>
        </tr>

    <?php endforeach; ?>

    </tbody>
</table>

<?php require 'footer.php'; ?>