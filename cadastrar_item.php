<?php 

require 'verifica_login.php';
require 'header.php'; 
require 'db.php';

$message = '';
$erro = '';

if(
    isset($_POST['titulo']) && !empty($_POST['titulo']) 
    && 
    isset($_POST['descricao']) && !empty($_POST['descricao']) 
    && 
    isset($_POST['quantidadeInicial']) && !empty($_POST['quantidadeInicial'])
) {

    $titulo = addslashes($_POST['titulo']);
    $descricao = addslashes($_POST['descricao']);
    $quantidadeInicial = addslashes($_POST['quantidadeInicial']);

    // Verificando se já existe um produto com aquele nome.
    $sql = "SELECT titulo FROM item";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $produtos = $stmt->fetchAll(PDO::FETCH_OBJ);

    $sql = "INSERT INTO item(titulo, descricao, quantidadeInicial) VALUES(:titulo, :descricao, :quantidadeInicial)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":titulo", $titulo);
    $stmt->bindValue(":descricao", $descricao);
    $stmt->bindValue(":quantidadeInicial", $quantidadeInicial);
    if($stmt->execute()) {
        $message = 'Produto cadastrado com sucesso!';
    } else {
        $erro = 'Erro ao cadastrar produto!';
    }
} 

?>

        <h3 class="fw-normal mt-5 text-center" style="letter-spacing: 1px;">Cadastrar Produto</h3>

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
                    <label class="form-label" for="form2Example18">Produto</label>
                    <input type="text" name="titulo" id="form2Example1" class="form-control form-control-lg" required />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example18">Descrição</label>
                    <input type="text" name="descricao" id="form2Example2" class="form-control form-control-lg" required />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example18">Quantidade em Estoque</label>
                    <input type="number" name="quantidadeInicial" id="form2Example3" class="form-control form-control-lg" required="required" />
                </div>

                <div class="pt-1 mb-4">
                    <button class="btn btn-info btn-lg btn-block" type="submit">Cadastrar Item</button>
                </div>

        </form>


<?php require 'footer.php'; ?>