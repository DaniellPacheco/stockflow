<?php
require 'verifica_login.php';
require 'header.php'; 
require 'db.php';

$sql = "SELECT id_usuario, nomeCompleto, email FROM usuario";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_OBJ);


?>

<a href="cadastrar_usuario.php" class="btn btn-success btn-lg mt-2" role="button"> 
    <img style="width: 25px;" src="./icones/user.svg" alt="Icone Usuário"> Novo Usuário
</a>

<table class="table mt-2">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Ações</th>
        <th scope="col">Usuario</th>
        <th scope="col">E-mail</th>
        </tr>
    </thead>
    <tbody>

    <?php foreach($usuarios as $usuario): ?>

        <tr>
            <td> 
                <a href="editar_usuario.php?id=<?php echo $usuario->id_usuario; ?>" class="btn btn-warning btn-sm mr-2" role="button">Editar</a> 
                <a onclick="return confirm('Você tem certeza disso?')" href="deletar_usuario.php?id=<?php echo $usuario->id_usuario; ?>" class="btn btn-danger btn-sm mr-2 text-white" role="button">Deletar</a>
            </td>
            <td><?php echo $usuario->nomeCompleto; ?></td>
            <td><?php echo $usuario->email; ?></td> 
        </tr>

    <?php endforeach; ?>

    </tbody>
</table>

<?php require 'footer.php'; ?>