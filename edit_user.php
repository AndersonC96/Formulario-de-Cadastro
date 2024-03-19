<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("Location: index.php");
        exit();
    }
    include 'db.php';
    if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
        header("Location: listar_usuarios.php");
        exit();
    }
    $id = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE id = ? AND id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows == 0){
        echo "Usuário não encontrado ou você não tem permissão para editar este usuário.";
        exit;
    }
    $user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Editar Usuário</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container mt-4">
            <h2>Editar Usuário</h2>
            <form action="atualizar_usuario.php" method="post">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="mb-3">
                    <label for="username" class="form-label">Nome de Usuário</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </form>
        </div>
    </body>
</html>