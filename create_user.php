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
    if(!$user['is_admin']){
        header("Location: dashboard.php");
        exit();
    }
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Processar criação de usuário aqui
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Criar Novo Usuário</title>
    </head>
    <body>
        <h2>Criar Novo Usuário</h2>
        <!-- Formulário para criar novo usuário -->
    </body>
</html>