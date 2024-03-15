<?php
    include 'db.php';
    require 'vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $data_inicio = isset($_POST['data_inicio']) ? $_POST['data_inicio'] : null;
        $data_fim = isset($_POST['data_fim']) ? $_POST['data_fim'] : null;
        $sql = "SELECT * FROM forms";
        if($data_inicio && $data_fim){
            $sql .= " WHERE data_hora BETWEEN '$data_inicio' AND '$data_fim'";
        }elseif($data_inicio){
            $sql .= " WHERE data_hora >= '$data_inicio'";
        }elseif ($data_fim){
            $sql .= " WHERE data_hora <= '$data_fim'";
        }
        $result = mysqli_query($conn, $sql);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nome');
        $sheet->setCellValue('C1', 'Telefone');
        $sheet->setCellValue('D1', 'Profissão');
        $sheet->setCellValue('E1', 'Número de Registro');
        $sheet->setCellValue('F1', 'Cidade');
        $sheet->setCellValue('G1', 'Estado');
        $sheet->setCellValue('H1', 'Data e Hora');
        $sheet->setCellValue('I1', 'Nome do Representante');
        $row = 2;
        while($row_data = mysqli_fetch_assoc($result)){
            $sheet->setCellValue('A' . $row, $row_data['id']);
            $sheet->setCellValue('B' . $row, $row_data['nome']);
            $sheet->setCellValue('C' . $row, $row_data['telefone']);
            $sheet->setCellValue('D' . $row, $row_data['profissao']);
            $sheet->setCellValue('E' . $row, $row_data['numero_registro']);
            $sheet->setCellValue('F' . $row, $row_data['cidade']);
            $sheet->setCellValue('G' . $row, $row_data['estado']);
            $sheet->setCellValue('H' . $row, $row_data['data_hora']);
            $sheet->setCellValue('I' . $row, $row_data['representante']);
            $row++;
        }
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="dados_formulario.xlsx"');
        header('Cache-Control: max-age=0');
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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">Exportar para Excel</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">Voltar ao Painel de Controle</a>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>