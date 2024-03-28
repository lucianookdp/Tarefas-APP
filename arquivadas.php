<?php
session_start(); // Inicia a sessão PHP para poder usar variáveis de sessão

// Checa se a lista de tarefas arquivadas existe na sessão e a recupera
if (isset($_SESSION['tarefas_arquivadas'])) {
    $tarefas_arquivadas = $_SESSION['tarefas_arquivadas'];
    unset($_SESSION['tarefas_arquivadas']); // Limpa a variável de sessão após o uso para evitar duplicação
} else {
    // Se não existir, define a ação para recuperar tarefas arquivadas e carrega o controller
    $acao = 'recuperarArquivadas';
    require 'tarefa_controller.php';
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Define o charset, viewport, título e links para folhas de estilo e ícones -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Lista Tarefas - Tarefas Arquivadas</title>
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
</head>
<body>
    <!-- Navegação -->
    <nav class="navbar navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
                App Lista Tarefas
            </a>
        </div>
    </nav>

    <!-- Conteúdo principal -->
    <div class="container app">
        <div class="row">
            <!-- Menu lateral -->
            <div class="col-md-3 menu">
                <ul class="list-group">
                    <li class="list-group-item"><a href="index.php">Tarefas pendentes</a></li>
                    <li class="list-group-item"><a href="nova_tarefa.php">Nova tarefa</a></li>
                    <li class="list-group-item active"><a href="arquivadas.php">Tarefas Arquivadas</a></li>
                </ul>
            </div>

            <!-- Seção das tarefas arquivadas -->
            <div class="col-md-9">
                <div class="container pagina">
                    <div class="row">
                        <div class="col">
                            <h4>Tarefas Arquivadas</h4>
                            <hr />
                            <!-- Verifica se existem tarefas arquivadas para exibir -->
                            <?php if(isset($tarefas_arquivadas) && count($tarefas_arquivadas) > 0): ?>
                                <!-- Loop através das tarefas arquivadas -->
                                <?php foreach ($tarefas_arquivadas as $indice => $tarefa): ?>
                                    <div class="row mb-3 d-flex align-items-center tarefa">
                                        <!-- Detalhes da tarefa -->
                                        <div class="col-sm-9" id="tarefa_<?= $tarefa->id ?>">
                                            <?= htmlspecialchars($tarefa->tarefa) ?> - <?= $tarefa->status ?>
                                            <div class="text-muted">
                                                <small>Criado em: <?= date('d/m/Y', strtotime($tarefa->data_criacao)) ?></small>
                                            </div>
                                        </div>
                                        <!-- Ações possíveis para cada tarefa -->
                                        <div class="col-sm-3 mt-2 d-flex justify-content-between">
                                            <i class="fas fa-trash-alt fa-lg text-danger" onclick="remover(<?= $tarefa->id ?>)"></i>
                                            <i class="fas fa-edit fa-lg text-info" onclick="editar(<?= $tarefa->id ?>, '<?= addslashes($tarefa->tarefa) ?>')"></i>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>Não há tarefas arquivadas.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
