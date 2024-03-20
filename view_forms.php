<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("Location: index.php");
        exit();
    }
    include 'db.php';
    $sql = "SELECT id, nome, telefone, celular, email, profissao, numero_registro, cidade, estado, data_hora FROM forms";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Simple Pharma | Visualizar Cadastros</title>
        <link rel="icon" href="https://static.wixstatic.com/media/5ede7b_719545c97a084f288b8566db52756425%7Emv2.png/v1/fill/w_180%2Ch_180%2Clg_1%2Cusm_0.66_1.00_0.01/5ede7b_719545c97a084f288b8566db52756425%7Emv2.png" type="image/x-icon" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link rel="stylesheet" href="./CSS/navbar.css">
        <style>
            .table{
                border-collapse: collapse;
                width: 100%;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                border-radius: 8px;
                overflow: hidden;
            }
            .table thead{
                background-color: #3ea5af;
                color: #ffffff;
            }
            .table thead th{
                padding: 10px 15px;
                text-align: left;
            }
            .table tbody tr:nth-child(odd){
                background-color: #f8f9fa;
            }
            .table tbody tr:hover{
                background-color: #e9ecef;
            }
            .table td{
                padding: 10px 15px;
                border-top: 1px solid #dee2e6;
            }
            .btn-primary{
                background-color: #007bff;
                border: none;
                padding: 5px 10px;
                color: white;
                border-radius: 5px;
                cursor: pointer;
            }
            .btn-primary:hover{
                background-color: #0056b3;
            }
            .btn-danger{
                background-color: #dc3545;
                border: none;
                padding: 5px 10px;
                color: white;
                border-radius: 5px;
                cursor: pointer;
            }
            .btn-danger:hover{
                background-color: #c82333;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-custom shadow-sm bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="https://static.wixstatic.com/media/fef91e_c3f644e14da442178f706149ae38d838~mv2.png/v1/crop/x_0,y_24,w_436,h_262/fill/w_120,h_71,al_c,q_85,usm_0.66_1.00_0.01,enc_auto/CAPA-03.png" alt="Logo" style="height: 50px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php"><i class="fas fa-home"></i> Voltar ao Início</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container mt-4">
            <h2>Cadastros Realizados</h2>
            <table class="table">
                <thead>
                    <tr>
                        <!--<th>ID</th>-->
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Celular</th>
                        <th>E-mail</th>
                        <th>Profissão</th>
                        <th>Número de Registro</th>
                        <th>Cidade</th>
                        <th>Estado</th>
                        <th>Data/Hora</th>
                        <th>Editar</th>
                        <th>Remover</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <!--<td><?= htmlspecialchars($row['id']) ?></td>-->
                        <td><?= htmlspecialchars($row['nome']) ?></td>
                        <td><?= htmlspecialchars($row['telefone']) ?></td>
                        <td><?= htmlspecialchars($row['celular']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['profissao']) ?></td>
                        <td><?= htmlspecialchars($row['numero_registro']) ?></td>
                        <td><?= htmlspecialchars($row['cidade']) ?></td>
                        <td><?= htmlspecialchars($row['estado']) ?></td>
                        <td><?= date('d/m/Y', strtotime($row['data_hora'])) ?></td>
                        <td><a href="edit_form.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Editar</a></td>
                        <td><a href="romove_form.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja remover este cadastro?')">Remover</a></td>
                    </tr>
                    <?php endwhile; ?>
                    <?php else: ?>
                    <tr><td colspan="10">Nenhum cadastro encontrado.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </body>
</html>