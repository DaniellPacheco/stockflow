<?php 

require 'verifica_login.php';
require 'header.php'; 
require 'db.php';

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

    // Verificando se já existe um usuário com aquele e-mail.
    $sql = "SELECT email FROM usuario";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $usuarios = $stmt->fetchAll(PDO::FETCH_OBJ);

    $resultado;
    foreach($usuarios as $usuario){
        if($usuario->email != $email) {
            $resultado = true;
        } else {
            $resultado = false;
            $erro = 'Usuário já existe.';
        }
    }
    
    // Caso o usuário não exista, inserir usuário.
    if($resultado) {
        $sql = "INSERT INTO usuario(nomeCompleto, email, senha) VALUES(:nomeCompleto, :email, :senha)";
    
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":nomeCompleto", $nomeCompleto);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":senha", md5($senha));
        if($stmt->execute()) {
            $message = 'Usuário cadastrado com sucesso!';
        } else {
            $erro = 'Erro ao inserir usuário.';
        }
    }

} 

?>

        <h3 class="fw-normal mt-5 text-center" style="letter-spacing: 1px;">Cadastrar Usuários</h3>

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
                    <label class="form-label" for="form2Example18">Nome Completo</label>
                    <input type="text" name="nomeCompleto" id="form2Example18" class="form-control form-control-lg" required />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example18">E-mail</label>
                    <input type="email" name="email" id="form2Example18" class="form-control form-control-lg" required />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example28">Senha</label>
                    <input type="password" name="senha" id="form2Example28" class="form-control form-control-lg" required />
                </div>

                <div class="pt-1 mb-4">
                    <button class="btn btn-info btn-lg btn-block" type="submit">Cadastrar Usuário</button>
                </div>

        </form>


<?php require 'footer.php'; ?>