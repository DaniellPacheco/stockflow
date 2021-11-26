<?php 
require 'verifica_login.php';
require 'header.php'; 
require 'db.php';

$id = $_GET['id'];

$sql = "SELECT * FROM item WHERE id_item = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $id);
$stmt->execute();
$item = $stmt->fetch(PDO::FETCH_OBJ);


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


    $sql = "UPDATE item SET titulo = :titulo, descricao = :descricao, quantidadeInicial = :quantidadeInicial WHERE id_item = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":id", $id);
    $stmt->bindValue(":titulo", $titulo);
    $stmt->bindValue(":descricao", $descricao);
    $stmt->bindValue(":quantidadeInicial", $quantidadeInicial);
    if($stmt->execute()) {
        $message = 'Produto atualizado com sucesso!';
        header("Location: itens.php");
    } else {
        $erro = 'Erro ao atualizar informações do produto!';
    }

} 

?>

        <h3 class="fw-normal mt-5 text-center" style="letter-spacing: 1px;">Editar - <?php echo $item->titulo; ?></h3>
 
        <?php if(!empty($message)):?>
            <div class="alert alert-success">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form style="width: 50rem;" method="POST" class="container mt-5">

                <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example18">Titulo</label>
                    <input value="<?php echo $item->titulo; ?>" type="text" name="titulo" id="form2Example18" class="form-control form-control-lg" required />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example18">Descrição</label>
                    <input value="<?php echo $item->descricao; ?>" type="text" name="descricao" id="form2Example18" class="form-control form-control-lg" required />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example18">Quantidade em Estoque</label>
                    <input value="<?php echo $item->quantidadeInicial; ?>" type="number" name="quantidadeInicial" id="form2Example18" class="form-control form-control-lg" required="required" />
                    
                </div>

                <div class="pt-1 mb-4">
                    <button class="btn btn-info btn-lg btn-block" type="submit">Editar Item</button>
                </div>

        </form>


<?php require 'footer.php'; ?>