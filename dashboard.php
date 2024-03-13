<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("Location: index.php");
        exit();
    }
    include 'db.php';
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Painel de Controle</title>
    </head>
    <body>
        <h2>Bem-vindo, <?php echo $user['username']; ?></h2>
        <a href="logout.php">Sair</a><br><br>
        <?php if($user['is_admin']) { ?>
        <a href="create_user.php">Criar Novo Usuário</a><br><br>
        <?php } ?>
        <a href="form.php">Formulário de Cadastro</a><br><br>
        <a href="export.php">Exportar para Excel</a>
    </body>
</html>