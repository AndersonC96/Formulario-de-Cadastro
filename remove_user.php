<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("Location: index.php");
        exit();
    }
    include 'db.php';
    if(isset($_GET['id']) && is_numeric($_GET['id'])){
        $id = $_GET['id'];
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT id FROM users WHERE id = ? AND (id = ? OR is_admin = 1)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            $sql = "DELETE FROM users WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            if($stmt->execute()){
                header("Location: view_users.php?remocao=sucesso");
            }else{
                header("Location: view_users.php?erro=nao-foi-possivel-remover");
            }
        }else{
            header("Location: view_users.php?erro=permissao-negada");
        }
    }else{
        header("Location: view_users.php");
        exit();
    }
?>
