<?php
// Incluir o arquivo de conexão com o banco de dados
include 'db.php';

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coletar os valores dos filtros, se existirem
    $data_inicio = isset($_POST['data_inicio']) ? $_POST['data_inicio'] : null;
    $data_fim = isset($_POST['data_fim']) ? $_POST['data_fim'] : null;

    // Preparar a consulta SQL base
    $sql = "SELECT * FROM forms";

    // Adicionar filtros de data à consulta SQL, se fornecidos
    if ($data_inicio && $data_fim) {
        $sql .= " WHERE data_hora BETWEEN '$data_inicio' AND '$data_fim'";
    } elseif ($data_inicio) {
        $sql .= " WHERE data_hora >= '$data_inicio'";
    } elseif ($data_fim) {
        $sql .= " WHERE data_hora <= '$data_fim'";
    }

    // Executar a consulta SQL
    $result = mysqli_query($conn, $sql);

    // Criar um objeto PHPExcel
    require_once 'PHPExcel.php';
    $objPHPExcel = new PHPExcel();

    // Definir o nome da planilha e criar a primeira planilha
    $objPHPExcel->getActiveSheet()->setTitle('Dados do Formulário');

    // Adicionar cabeçalhos à planilha
    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'ID');
    $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Nome');
    $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Telefone');
    $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Profissão');
    $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Número de Registro');
    $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Cidade');
    $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Estado');
    $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Data e Hora');
    $objPHPExcel->getActiveSheet()->setCellValue('I1', 'Nome do Representante');

    // Adicionar dados à planilha
    $row = 2;
    while ($row_data = mysqli_fetch_assoc($result)) {
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $row_data['id']);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $row_data['nome']);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $row_data['telefone']);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $row_data['profissao']);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $row_data['numero_registro']);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $row_data['cidade']);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $row_data['estado']);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $row_data['data_hora']);
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $row_data['representante']);
        $row++;
    }

    // Definir o formato do arquivo Excel
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="dados_formulario.xlsx"');
    header('Cache-Control: max-age=0');

    // Salvar o arquivo Excel no buffer de saída
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');

    // Finalizar o script
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exportar para Excel</title>
    <!-- Adicionando Bootstrap 5 -->
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
                            <label for="data_inicio" class="form-label">Data de Início:</label>
                            <input type="date" class="form-control" id="data_inicio" name="data_inicio">
                        </div>
                        <div class="mb-3">
                            <label for="data_fim" class="form-label">Data de Término:</label>
                            <input type="date" class="form-control" id="data_fim" name="data_fim">
                        </div>
                        <button type="submit" class="btn btn-primary">Exportar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Adicionando JavaScript do Bootstrap 5 (opcional, mas necessário para funcionalidades como o menu suspenso da navbar) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
