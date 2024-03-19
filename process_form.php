<?php
    include 'db.php';
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $nome = $_POST['nome'];
        $telefone = $_POST['telefone'];
        $celuar = $_POST['celular'];
        $email = $_POST['email'];
        $profissao = $_POST['profissao'];
        $numero_registro = $_POST['numero_registro'];
        $cidade = $_POST['cidade'];
        $estado = $_POST['estado'];
        $data_hora = $_POST['data_hora'];
        $representante = $_POST['representante'];
        $sql = "INSERT INTO forms (nome, telefone, celular, email, profissao, numero_registro, cidade, estado, data_hora, representante) VALUES ('$nome', '$telefone', '$celular', '$email', '$profissao', '$numero_registro', '$cidade', '$estado', '$data_hora', '$representante')";
        if(mysqli_query($conn, $sql)){
            header("Location: form.php?success=true");
            exit();
        }else{
            header("Location: form.php?success=false&error=" . urlencode(mysqli_error($conn)));
            exit();
        }
    }else{
        header("Location: form.php");
        exit();
    }
?>