<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("Location: index.php");
        exit();
    }
    include 'db.php';
    require 'vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        $user = $result->fetch_assoc();
        $nome_do_usuario = $user['nome'];
    }else{
        header("Location: index.php");
        exit();
    }

    function formatPhoneNumber($phoneNumber){
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
        if(strlen($phoneNumber) == 10){
            return preg_replace('/^(\d{2})(\d{4})(\d{4})$/', '($1) $2-$3', $phoneNumber);
        }else{
            return preg_replace('/^(\d{2})(\d{5})(\d{4})$/', '($1) $2-$3', $phoneNumber);
        }
    }

    function formatDateTime($dateTime){
        return date('d/m/Y H:i', strtotime($dateTime));
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $data_inicio = isset($_POST['data_inicio']) ? $_POST['data_inicio'] : null;
        $data_fim = isset($_POST['data_fim']) ? $_POST['data_fim'] : null;
        $sql = "SELECT * FROM forms";
        if($data_inicio && $data_fim){
            $sql .= " WHERE data_hora BETWEEN '$data_inicio' AND '$data_fim'";
        }elseif ($data_inicio){
            $sql .= " WHERE data_hora >= '$data_inicio'";
        }elseif($data_fim){
            $sql .= " WHERE data_hora <= '$data_fim'";
        }
        $result = mysqli_query($conn, $sql);

        // Definindo os cabeçalhos antes de qualquer saída
        $filename = 'dados_' . date('d-m-Y_H-i-s') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Nome');
        $sheet->setCellValue('B1', 'Telefone');
        $sheet->setCellValue('C1', 'Celular');
        $sheet->setCellValue('D1', 'Email');
        $sheet->setCellValue('E1', 'Profissão');
        $sheet->setCellValue('F1', 'Número de Registro');
        $sheet->setCellValue('G1', 'Conselho');
        $sheet->setCellValue('H1', 'Evento');
        //$sheet->setCellValue('H1', isset($row_data['evento']) ? $row_data['evento'] : '');
        $sheet->setCellValue('I1', 'Cidade');
        $sheet->setCellValue('J1', 'Estado');
        $sheet->setCellValue('K1', 'Data e Hora');
        $sheet->setCellValue('L1', 'Nome do Representante');
        $spreadsheet->getActiveSheet()->getStyle('A1:L1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'name' => 'Arial',
                'color' => [
                    'rgb' => 'FFFFFF',
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '60b5ba',
                ],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);
        $row = 2;
        while($row_data = mysqli_fetch_assoc($result)){
            $sheet->setCellValue('A' . $row, $row_data['nome']);
            $sheet->setCellValue('B' . $row, formatPhoneNumber($row_data['telefone']));
            $sheet->setCellValue('C' . $row, formatPhoneNumber($row_data['celular']));
            $sheet->setCellValue('D' . $row, $row_data['email']);
            $sheet->setCellValue('E' . $row, $row_data['profissao']);
            $sheet->setCellValueExplicit('F' . $row, $row_data['numero_registro'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('G' . $row, $row_data['conselho']);
            $sheet->setCellValue('H' . $row, $row_data['evento']);
            //$sheet->setCellValue('H' . $row, isset($row_data['evento']) ? $row_data['evento'] : '');
            $sheet->setCellValue('I' . $row, $row_data['cidade']);
            $sheet->setCellValue('J' . $row, $row_data['estado']);
            $sheet->setCellValue('K' . $row, formatDateTime($row_data['data_hora']));
            $sheet->setCellValue('L' . $row, $row_data['representante']);
            $spreadsheet->getActiveSheet()->getStyle('A' . $row . ':L' . $row)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $spreadsheet->getActiveSheet()->getStyle('A' . $row . ':L' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('A' . $row . ':L' . $row)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('A' . $row . ':L' . $row)->applyFromArray([
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'rgb' => 'F0F0F0',
                    ],
                ],
            ]);
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Exportar para Excel</title>
        <link rel="icon" href="https://static.wixstatic.com/media/5ede7b_719545c97a084f288b8566db52756425%7Emv2.png/v1/fill/w_180%2Ch_180%2Clg_1%2Cusm_0.66_1.00_0.01/5ede7b_719545c97a084f288b8566db52756425%7Emv2.png" type="image/x-icon" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link rel="stylesheet" href="./CSS/navbar.css">
        <style>
            .navbar-custom{
                background-color: #f8f9fa;
            }
            .navbar-custom .nav-link{
                color: #000;
            }
            .navbar-custom .nav-link:hover{
                color: #60b5ba;
            }
            .navbar-custom .navbar-brand img{
                border-radius: 10px;
            }
            .container h1{
                text-align: center;
                margin-top: 20px;
                font-size: 2.5em;
                color: #333;
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
            .card-header{
                background-color: #60b5ba;
                color: #fff;
                text-align: center;
            }
            .btn-primary{
                background-color: #60b5ba;
                border-color: #60b5ba;
            }
            .btn-primary:hover{
                background-color: #53a8b1;
                border-color: #53a8b1;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container">
                <a class="navbar-brand" href="dashboard.php"><img src="https://static.wixstatic.com/media/fef91e_c3f644e14da442178f706149ae38d838~mv2.png/v1/crop/x_0,y_24,w_436,h_262/fill/w_120,h_71,al_c,q_85,usm_0.66_1.00_0.01,enc_auto/CAPA-03.png" alt="Logo"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
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
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="text-center">Exportar para Excel</h2>
                        </div>
                        <div class="card-body">
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="mb-3">
                                    <label for="data_inicio" class="form-label">Data de Início</label>
                                    <input type="date" class="form-control" id="data_inicio" name="data_inicio">
                                </div>
                                <div class="mb-3">
                                    <label for="data_fim" class="form-label">Data de Término</label>
                                    <input type="date" class="form-control" id="data_fim" name="data_fim">
                                </div>
                                <button type="submit" class="btn btn-primary">Exportar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            if(new URLSearchParams(window.location.search).get('success') === 'true'){
                alert('Usuário criado com sucesso!');
                window.location.href = 'dashboard.php';
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
