<?php
    include 'db.php';
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $nome = $_POST['nome'];
        $telefone = $_POST['telefone'];
        $celular = $_POST['celular'];
        $email = $_POST['email'];
        $profissao = $_POST['profissao'];
        $numero_registro = $_POST['numero_registro'];
        $conselho = $_POST['conselho'];
        $evento = $_POST['evento'];
        $cidade = $_POST['cidade'];
        $estado = $_POST['estado'];
        $data_hora = $_POST['data_hora'];
        $representante = $_POST['representante'];
        $sql = "INSERT INTO forms (nome, telefone, celular, email, profissao, numero_registro, conselho, evento, cidade, estado, data_hora, representante) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssssss", $nome, $telefone, $celular, $email, $profissao, $numero_registro, $conselho, $evento, $cidade, $estado, $data_hora, $representante);
        if($stmt->execute()){
            header("Location: form.php?success=true");
            exit();
        }else{
            header("Location: form.php?success=false&error=" . urlencode($stmt->error));
            exit();
        }
    }
?>