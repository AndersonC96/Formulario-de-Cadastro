<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("Location: index.php");
        exit();
    }
    include 'db.php';
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($user = $result->fetch_assoc()){
        $_SESSION['user_type'] = $user['is_admin'] ? 'admin' : 'user';
    }
    $sql = "SELECT id, nome, telefone, celular, email, representante, profissao, numero_registro, conselho, evento, cidade, estado, data_hora FROM forms";
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
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
        <style>
            .navbar-custom{
                background-color: #f8f9fa;
            }
            .navbar-custom .nav-link{
                color: #000;
            }
            .navbar-custom .nav-link:hover{
                color: #007bff;
            }
            .navbar-custom .navbar-brand img{
                border-radius: 10px;
            }
            .navbar-toggler{
                border-color: rgba(0, 0, 0, 0.1);
            }
            .navbar-toggler-icon{
                color: #000;
            }
            .nav-item{
                border-radius: 15px;
                margin: 0 5px;
            }
            .nav-link{
                border-radius: 15px;
                transition: background-color 0.3s;
            }
            .nav-link:hover{
                background-color: #e9ecef;
            }
            .dropdown-menu{
                border-radius: 10px;
                background-color: #f8f9fa;
            }
            .dropdown-item{
                transition: background-color 0.3s;
            }
            .dropdown-item:hover{
                background-color: #e9ecef;
            }
            .table{
                border-collapse: collapse;
                width: 100%;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
            .dataTables_filter{
                display: none;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container">
                <a class="navbar-brand" href="dashboard.php"><img src="https://static.wixstatic.com/media/fef91e_c3f644e14da442178f706149ae38d838~mv2.png/v1/crop/x_0,y_24,w_436,h_262/fill/w_120,h_71,al_c,q_85,usm_0.66_1.00_0.01,enc_auto/CAPA-03.png" alt="Logo"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php"><i class="fas fa-home"></i> Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="form.php"><i class="fas fa-edit"></i> Formulário</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="view_forms.php"><i class="fas fa-eye"></i> Ver Formulários</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="export.php"><i class="fas fa-file-export"></i> Exportar</a>
                        </li>
                        <?php if ($user['is_admin']){ ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-users"></i> Usuários
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="create_user.php"><i class="fas fa-user-plus"></i> Criar Usuário</a></li>
                                <li><a class="dropdown-item" href="view_users.php"><i class="fas fa-users"></i> Ver Usuários</a></li>
                            </ul>
                        </li>
                        <?php } ?>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container mt-4">
            <h2>Cadastros Realizados</h2>
            <div class="row mt-3 mb-3 d-none">
                <div class="col-md-4">
                    <label for="startDate">Data Inicial</label>
                    <input type="text" id="startDate" class="form-control datepicker">
                </div>
                <div class="col-md-4">
                    <label for="endDate">Data Final</label>
                    <input type="text" id="endDate" class="form-control datepicker">
                </div>
            </div>
            <div class="table-responsive mt-3">
                <table id="cadastrosTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <th>Celular</th>
                            <th>E-mail</th>
                            <th>Representante</th>
                            <th>Profissão</th>
                            <th>Nº de Registro</th>
                            <th>Conselho</th>
                            <th>Evento</th>
                            <th>Cidade</th>
                            <th>Estado</th>
                            <th>Data</th>
                            <?php if ($user['is_admin']){ ?>
                            <th>Editar</th>
                            <th>Remover</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0) : ?>
                        <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nome']) ?></td>
                            <td><?= htmlspecialchars($row['telefone']) ?></td>
                            <td><?= htmlspecialchars($row['celular']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['representante']) ?></td>
                            <td><?= htmlspecialchars($row['profissao']) ?></td>
                            <td><?= htmlspecialchars($row['numero_registro']) ?></td>
                            <td><?= htmlspecialchars($row['conselho']) ?></td>
                            <td><?= htmlspecialchars($row['evento']) ?></td>
                            <td><?= htmlspecialchars($row['cidade']) ?></td>
                            <td><?= htmlspecialchars($row['estado']) ?></td>
                            <td><?= date('d/m/Y', strtotime($row['data_hora'])) ?></td>
                            <?php if ($user['is_admin']){ ?>
                            <td><a href="edit_form.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Editar</a></td>
                            <td><a href="remove_form.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja remover este cadastro?')">Remover</a></td>
                            <?php } ?>
                        </tr>
                        <?php endwhile; ?>
                        <?php else : ?>
                        <tr>
                            <td colspan="13">Nenhum cadastro encontrado.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.pt-BR.min.js"></script>
        <script>
            $(document).ready(function(){
                $('.datepicker').datepicker({
                    format: 'dd/mm/yyyy',
                    language: 'pt-BR',
                    autoclose: true
                });
                var table = $('#cadastrosTable').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "pageLength": 10,
                    "searching": true,
                    "ordering": true,
                    "order": [
                        [11, 'asc']
                    ],
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                    "language":{
                        "paginate":{
                            "first": "Primeiro",
                            "last": "Último",
                            "next": "Próximo",
                            "previous": "Anterior"
                        },
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                        "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                        "emptyTable": "Nenhum cadastro encontrado",
                        "search": "Pesquisar:",
                        "infoFiltered": "(filtrado de _MAX_ registros totais)"
                    },
                    "columnDefs": [{
                        "targets": 11,
                        "render": function(data, type, row){
                            if(type === 'sort' || type === 'type'){
                                return data.split('/').reverse().join('');
                            }
                            return data;
                        }
                    }]
                });
                $('#startDate, #endDate').change(function(){
                    table.draw();
                });
                $.fn.dataTable.ext.search.push(function(settings, data, dataIndex){
                    var startDate = $('#startDate').datepicker('getDate');
                    var endDate = $('#endDate').datepicker('getDate');
                    var colDate = data[11].split('/');
                    var date = new Date(colDate[2], colDate[1] - 1, colDate[0]);
                    if(!startDate && !endDate){
                        return true;
                    }
                    if(!startDate && date <= endDate){
                        return true;
                    }
                    if(!endDate && date >= startDate){
                        return true;
                    }
                    if(date >= startDate && date <= endDate){
                        return true;
                    }
                    return false;
                });
            });
        </script>
    </body>
</html>