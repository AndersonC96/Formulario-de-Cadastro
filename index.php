<?php
    session_start();
    if(isset($_SESSION['user_id'])){
        header("Location: dashboard.php");
        exit();
    }
    include 'db.php';
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) == 1){
            $row = mysqli_fetch_assoc($result);
            $_SESSION['user_id'] = $row['id'];
            header("Location: dashboard.php");
            exit();
        }else{
            $error = "Usuário ou senha incorretos.";
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Página de Login</title>
    </head>
    <body>
        <h2>Login</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label>Usuário:</label>
            <input type="text" name="username" required><br><br>
            <label>Senha:</label>
            <input type="password" name="password" required><br><br>
            <input type="submit" value="Login">
        </form>
        <?php if(isset($error)) { echo $error; } ?>
    </body>
</html>