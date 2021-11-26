<?php 
require 'verifica_login.php';
require 'header.php'; 
require 'db.php';

$message = '';
$erro = '';

$sql = "SELECT * FROM item";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$emprestados = $stmt->fetchAll(PDO::FETCH_OBJ);

if(
    isset($_POST['nomeCompleto']) && !empty($_POST['nomeCompleto']) 
    && 
    isset($_POST['email']) && !empty($_POST['email'])
    &&
    isset($_POST['cep']) && !empty($_POST['cep'])
    &&
    isset($_POST['endereco']) && !empty($_POST['endereco'])
    &&
    isset($_POST['cidade']) && !empty($_POST['cidade'])
    &&
    isset($_POST['estado']) && !empty($_POST['estado'])
    &&
    isset($_POST['item']) && !empty($_POST['item'])
    &&
    isset($_POST['quantidade']) && !empty($_POST['quantidade'])
    &&
    isset($_POST['dataParaDevolucao']) && !empty($_POST['dataParaDevolucao'])
) {

    $nomeCompleto = addslashes($_POST['nomeCompleto']);
    $email = addslashes($_POST['email']);
    $cep = addslashes($_POST['cep']);
    $endereco = addslashes($_POST['endereco']);
    $cidade = addslashes($_POST['cidade']);
    $estado = addslashes($_POST['estado']);
    $id_item = addslashes($_POST['item']);
    $quantidade = addslashes($_POST['quantidade']);
    $dataParaDevolucao = addslashes($_POST['dataParaDevolucao']);


    // Atualizando item
    $sql = "SELECT * FROM item WHERE id_item = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":id", $id_item);
    $stmt->execute();
    $item = $stmt->fetch(PDO::FETCH_OBJ);

    $soma = $item->quantidadeEmprestada + $quantidade;

    // Verificando se a quantidade em estoque é maior ou igual a quantidade a ser inserida.
    if($item->quantidadeInicial >= $soma) {
        
        // Pegar o próximo id
        $sql = "SELECT max(id_emprestado) quantidade from emprestado";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $item = $stmt->fetch(PDO::FETCH_OBJ);
        $proximoId = $item->quantidade + 1;
        
        // Inserir registro de emprestado.
        $sql = "INSERT INTO emprestado(id_emprestado, nomeCompleto, email, cep, endereco, cidade, estado, id_item, quantidade, dataParaDevolucao) VALUES(:id_emprestado, :nomeCompleto, :email, :cep, :endereco, :cidade, :estado, :id_item, :quantidade, :dataParaDevolucao)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":id_emprestado", $proximoId);
        $stmt->bindValue(":nomeCompleto", $nomeCompleto);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":cep", $cep);
        $stmt->bindValue(":endereco", $endereco);
        $stmt->bindValue(":cidade", $cidade);
        $stmt->bindValue(":estado", $estado);
        $stmt->bindValue(":id_item", $id_item);
        $stmt->bindValue(":quantidade", $quantidade);
        $stmt->bindValue(":dataParaDevolucao", $dataParaDevolucao);
        if($stmt->execute()) {
            $message = 'Item emprestado com sucesso!';
        }
        
        // Atualizar quantidade emprestada do item selecionado.
        $sql = "UPDATE item SET quantidadeEmprestada = :quantidade WHERE id_item = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":quantidade", $soma);
        $stmt->bindValue(":id", $id_item);
        if($stmt->execute()) {
            $message = 'Emprestimo efetuado com sucesso!';
        } else {
            $erro = 'Erro ao realizar emprestimo de item';
        }
        
    } else {
        $erro = 'Quantidade itens indisponível no estoque.';
    }
} 

?>

        <h3 class="fw-normal mt-5 text-center" style="letter-spacing: 1px;">Emprestar Item</h3>

        <?php if(!empty($message)):?>
            <div class="alert alert-success">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <?php if(!empty($erro)):?>
            <div class="alert alert-danger">
                <?php echo $erro; ?>
            </div>
        <?php endif; ?>

        <form style="width: 50rem;" method="POST" class="container mt-5">
        
                <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example18">Nome Completo Solicitante</label>
                    <input type="text" name="nomeCompleto" id="form2Example18" class="form-control form-control-lg" required />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example18">E-mail de Contato</label>
                    <input type="email" name="email" id="form2Example25" class="form-control form-control-lg" required />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example18">CEP</label>
                    <input type="text" name="cep" id="form2Example19" class="form-control form-control-lg" required />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example18">Endereço</label>
                    <input type="text" name="endereco" id="form2Example20" class="form-control form-control-lg" required />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example18">Cidade</label>
                    <input type="text" name="cidade" id="form2Example21" class="form-control form-control-lg" required />
                </div>


                <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example18">Estado</label>
                    <input type="text" name="estado" id="form2Example22" class="form-control form-control-lg" required />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="item">Item Para Emprestar</label>
                    <select class="form-control form-control-lg" name="item" id="form2Example26">
                        <?php foreach($emprestados as $emprestado):?>
                            <option value="<?php echo $emprestado->id_item; ?>"><?php echo $emprestado->titulo; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example18">Quantidade a Emprestar</label>
                    <input type="number" name="quantidade" id="form2Example23" class="form-control form-control-lg" placeholder="0" required="required" />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example18">Previsão Entrega</label>
                    <input type="date" name="dataParaDevolucao" id="form2Example24" class="form-control form-control-lg" placeholder="0" required="required" />
                </div>

                <div class="pt-1 mb-4">
                    <button class="btn btn-info btn-lg btn-block" type="submit">Emprestar Item</button>
                </div>

        </form>


<?php require 'footer.php'; ?>