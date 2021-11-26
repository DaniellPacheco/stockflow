<?php 
require 'verifica_login.php';
require 'header.php';
require 'db.php';

$id = $_GET['id'];

$sql = "SELECT * FROM usuario WHERE id_usuario = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $id);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_OBJ);

$message = '';
$erro = '';

if(
    isset($_POST['nomeCompleto']) && !empty($_POST['nomeCompleto']) 
    &&
    isset($_POST['email']) && !empty($_POST['email'])
    &&
    isset($_POST['senha']) && !empty($_POST['senha'])
) {

    $nomeCompleto = addslashes($_POST['nomeCompleto']);
    $email = addslashes($_POST['email']);
    $senha = addslashes($_POST['senha']);

    $sql = "UPDATE usuarios SET nomeCompleto = :nomeCompleto, email = :email, senha = :senha WHERE id_usuario = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":id", $id);
    $stmt->bindValue(":nomeCompleto", $nomeCompleto);
    $stmt->bindValue(":email", $email);
    $stmt->bindValue(":senha", md5($senha));

    if($stmt->execute()) {
        header("Location: usuarios.php");
    } 

}


?>

<h3 class="fw-normal mt-5 text-center" style="letter-spacing: 1px;">Editar <?php echo $usuario->nomeCompleto; ?></h3>

<form style="width: 50rem;" method="POST" class="container mt-5">

    <div class="form-outline mb-4">
        <label class="form-label" for="form2Example18">Nome Completo</label>
        <input value="<?php echo $usuario->nomeCompleto; ?>" type="text" name="nomeCompleto" id="form2Example18" class="form-control form-control-lg" required />
    </div>

    <div class="form-outline mb-4">
        <label class="form-label" for="form2Example18">E-mail</label>
        <input value="<?php echo $usuario->email; ?>" type="email" name="email" id="form2Example18" class="form-control form-control-lg" required />
    </div>

    <div class="form-outline mb-4">
        <label class="form-label" for="form2Example28">Senha</label>
        <input type="password" name="senha" id="form2Example28" class="form-control form-control-lg" required />
    </div>

    <div class="pt-1 mb-4">
        <button class="btn btn-info btn-lg btn-block" type="submit">Editar</button>
    </div>

</form>


<?php require 'footer.php'; ?>