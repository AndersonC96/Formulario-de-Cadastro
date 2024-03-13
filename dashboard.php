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
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Painel de Controle</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">Painel de Controle</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="form.php">Formulário</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="export.php">Exportar</a>
                        </li>
                        <?php if($user['is_admin']) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="create_user.php">Criar Usuário</a>
                        </li>
                        <?php } ?>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Sair</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <h1>Bem-vindo, <b style="color: rgb(83 168 177)"><?php echo $_SESSION['sess_usersisname']; ?></b></h1>
            <!--<h1>Bem-vindo</b></h1>-->
            <p>Algumas funcionalidades podem não estar ativas ainda.</p>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
