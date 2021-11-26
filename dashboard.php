<?php 

require 'verifica_login.php';

require 'header.php'; 
require 'db.php';

$sql = "SELECT E.*, T.* FROM emprestado E INNER JOIN item T ON E.id_item = T.id_item ORDER BY E.dataCriacao DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$emprestados = $stmt->fetchAll(PDO::FETCH_OBJ);
?>

<div class="d-grid gap-2 d-md-flex justify-content-center mt-4">
    <a href="itens.php" class="btn btn-warning btn-lg mr-2 " role="button">
        <img style="width: 25px; margin-right: 5px;" src="./icones/add.svg" alt="Icone Cadastrar Item"> Produtos
    </a>
    <a href="emprestar_item.php" class="btn btn-danger btn-lg mr-2 text-white" role="button">
        <img style="width: 25px; margin-right: 5px;" src="./icones/send.svg" alt="Icone Emprestar Item"> Emprestar Item</a>
</div>

<table class="table mt-2">
    <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Produto</th>
            <th scope="col">Descrição</th>
            <th scope="col">Estoque</th>
            <th scope="col">Emprestado</th>
            <th scope="col">Disponível</th>
            <th scope="col">Editar</th>
            <th scope="col">Deletar</th>
            <th scope="col">Entregar</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($emprestados as $itemEmprestado):

            $entregue = '';
            if(!empty($itemEmprestado->dataEntrega)) {
                $entregue = 'background: #ecf0f1;';
            }

            $styleDataEtrega = '';
            if(empty($itemEmprestado->descricao)){
                $style = 'background: #2ecc71;';
            }
             ?>

                <tr style="<?php echo $styleDataEtrega; echo $entregue; ?>">
                    <td class="col-1"><?php echo $itemEmprestado->id_emprestado; ?></td>
                    <td class="col-3"><strong><?php echo $itemEmprestado->titulo; ?></strong></td>
                    <td class="col-2"><?php echo $itemEmprestado->descricao; ?></td>
                    <td class="col-1 text-center"><?php echo $itemEmprestado->quantidadeInicial; ?></td>
                    <td class="col-1 text-center"><?php echo $itemEmprestado->quantidadeEmprestada; ?></td>
                    <td class="col-1 text-center"><?php echo $itemEmprestado->quantidadeInicial - $itemEmprestado->quantidadeEmprestada; ?></td>
                    <td class="text-center">
                        <a href="editar_emprestimo.php?id=<?php echo $itemEmprestado->id_emprestado; ?>" class="btn btn-warning btn-sm mr-2" role="button">
                            <img style="width: 20px;" class="text-warning" src="./icones/edit.svg" alt="Botão Editar">
                        </a> 
                    </td>
                    <td class="text-center">
                        <a onclick="return confirm('Você tem certeza disso?')" href="deletar_emprestimo.php?id=<?php echo $itemEmprestado->id_emprestado; ?>" class="btn btn-danger btn-sm mr-2 text-white" role="button">
                            <img style="width: 20px;" src="./icones/delete.svg" alt="Botão Deletar">
                        </a>
                    </td>
                    <td class="text-center">
                        <a onclick="return confirm('Você tem certeza disso?')" href="entregar.php?id=<?php echo $itemEmprestado->id_emprestado; ?>" class="btn btn-success btn-sm mr-2 text-white" role="button">
                            <img style="width: 20px;" src="./icones/verify.svg" alt="Botão Entregar">
                        </a>
                    </td>
                </tr>


    <?php endforeach; ?>
    </tbody>
</table>

<?php require 'footer.php'; ?>