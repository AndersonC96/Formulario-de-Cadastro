<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formulário de Cadastro</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">Formulário de Cadastro</a>
                <a class="nav-link" href="dashboard.php">Voltar ao Início</a>
            </div>
        </nav>
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="text-center">Preencha o Formulário</h2>
                        </div>
                        <div class="card-body">
                            <?php if(isset($_GET['success']) && $_GET['success'] == "true") { ?>
                            <div class="alert alert-success" role="alert">Formulário enviado com sucesso!</div>
                            <?php } elseif(isset($_GET['success']) && $_GET['success'] == "false") { ?>
                            <div class="alert alert-danger" role="alert">Ocorreu um erro ao enviar o formulário: <?php echo $_GET['error']; ?></div>
                            <?php } ?>
                            <form method="post" action="process_form.php">
                                <div class="mb-3">
                                    <label for="nome" class="form-label">Nome</label>
                                    <input type="text" class="form-control" id="nome" name="nome" required>
                                </div>
                                <div class="mb-3">
                                    <label for="telefone" class="form-label">Telefone</label>
                                    <input type="text" class="form-control" id="telefone" name="telefone" required>
                                </div>
                                <div class="mb-3">
                                    <label for="profissao" class="form-label">Profissão</label>
                                    <input type="text" class="form-control" id="profissao" name="profissao" required>
                                </div>
                                <div class="mb-3">
                                    <label for="numero_registro" class="form-label">Número de Registro</label>
                                    <input type="text" class="form-control" id="numero_registro" name="numero_registro" required>
                                </div>
                                <div class="mb-3">
                                    <label for="cidade" class="form-label">Cidade</label>
                                    <input type="text" class="form-control" id="cidade" name="cidade" required>
                                </div>
                                <div class="mb-3">
                                    <label for="estado" class="form-label">Estado</label>
                                    <select class="form-select" id="estado" name="estado" required>
                                        <option value="">Selecione o Estado</option>
                                        <option value="AC">Acre</option>
                                        <option value="AL">Alagoas</option>
                                        <option value="SE">Sergipe</option>
                                        <option value="SP">São Paulo</option>
                                        <option value="TO">Tocantins</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="data_hora" class="form-label">Data e Hora</label>
                                    <input type="text" class="form-control" id="data_hora" name="data_hora" readonly required>
                                </div>
                                <div class="mb-3">
                                    <label for="representante" class="form-label">Nome do Representante</label>
                                    <input type="text" class="form-control" id="representante" name="representante" value="<?php echo $_SESSION['sess_usersisname']; ?>" readonly required>
                                </div>
                                <button type="submit" class="btn btn-primary">Enviar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function capturarDataHora(){
                const dataHora = new Date().toLocaleString('pt-BR', { timeZone: 'America/Sao_Paulo' });
                document.getElementById('data_hora').value = dataHora;
            }
            capturarDataHora();
        </script>
    </body>
</html>