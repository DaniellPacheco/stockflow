<?php 
require 'verifica_login.php';
require 'header.php'; 
require 'db.php';

$id = $_GET['id'];

// Buscando Item
$sql = "SELECT * FROM emprestado WHERE id_emprestado = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $id);
$stmt->execute();
$emprestados = $stmt->fetch(PDO::FETCH_OBJ);

// Pegando item
$sql = "SELECT * FROM item WHERE id_item = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $emprestados->id_item);
$stmt->execute();
$item = $stmt->fetch(PDO::FETCH_OBJ);

$message = '';
$erro = '';

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
    $item = addslashes($_POST['item']);
    $quantidade = addslashes($_POST['quantidade']);
    $dataParaDevolucao = addslashes($_POST['dataParaDevolucao']);
    $dataEntrega = addslashes($_POST['dataEntrega']);

    // Atualizando informações.
    $sql = "UPDATE emprestado SET nomeCompleto = :nomeCompleto, cep = :cep, endereco = :endereco, cidade = :cidade, estado = :estado, dataParaDevolucao = :dataParaDevolucao WHERE id_emprestado = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":id", $id);
    $stmt->bindValue(":nomeCompleto", $nomeCompleto);
    $stmt->bindValue(":cep", $cep);
    $stmt->bindValue(":endereco", $endereco);
    $stmt->bindValue(":cidade", $cidade);
    $stmt->bindValue(":estado", $estado);
    $stmt->bindValue(":dataParaDevolucao", $dataParaDevolucao);
    if($stmt->execute()) {
        $message = 'Informações atualizadas com sucesso!';
    } else {
        $erro = 'Erro ao atualizar informações.';
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
                    <input value="<?php echo $emprestados->nomeCompleto; ?>" type="text" name="nomeCompleto" id="form2Example18" class="form-control form-control-lg" required />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example18">E-mail de Contato</label>
                    <input value="<?php echo $emprestados->email; ?>"  type="email" name="email" id="form2Example25" class="form-control form-control-lg" />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example18">CEP</label>
                    <input value="<?php echo $emprestados->cep; ?>" type="text" name="cep" id="form2Example19" class="form-control form-control-lg" required />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example18">Endereço</label>
                    <input value="<?php echo $emprestados->endereco; ?>" type="text" name="endereco" id="form2Example20" class="form-control form-control-lg" required />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example18">Cidade</label>
                    <input value="<?php echo $emprestados->cidade; ?>" type="text" name="cidade" id="form2Example21" class="form-control form-control-lg" required />
                </div>


                <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example18">Estado</label>
                    <input value="<?php echo $emprestados->estado; ?>" type="text" name="estado" id="form2Example22" class="form-control form-control-lg" required />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="item">Item Para Emprestar</label>
                    <select class="form-control form-control-lg" name="item" id="form2Example26"  >
                            <option value="<?php echo $item->id_item; ?>"><?php echo $item->titulo; ?></option>
                    </select>
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example18">Quantidade</label>
                    <input value="<?php echo $emprestados->quantidade; ?>" type="number" name="quantidade" id="form2Example23" class="form-control form-control-lg" placeholder="0"  />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example18">Data Para Devolução</label>
                    <input value="<?php echo $emprestados->dataParaDevolucao; ?>" type="date" name="dataParaDevolucao" id="form2Example24" class="form-control form-control-lg" required="required" />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example18">Data Entrega</label>
                    <input value="<?php echo $emprestados->dataEntrega; ?>" type="date" name="dataEntrega" id="form2Example24" class="form-control form-control-lg" />
                </div>

                <div class="pt-1 mb-4">
                    <button class="btn btn-info btn-lg btn-block" type="submit">Editar Emprestimo</button>
                </div>

        </form>


<?php require 'footer.php'; ?>