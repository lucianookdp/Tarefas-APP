<?php

// Inclui as dependências necessárias: modelo de tarefas, serviço de tarefas e conexão com o banco de dados.
require "tarefa.model.php";
require "tarefa.service.php";
require "conexao.php";

// Determina a ação a ser realizada com base no parâmetro 'acao' recebido via GET ou definido anteriormente no código.
$acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;

// Inicia uma sessão PHP se ainda não estiver iniciada, para usar variáveis de sessão.
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

// Estrutura condicional que determina o fluxo de ação baseado no valor da variável $acao.
if ($acao == 'inserir') {
    // Bloco para inserir uma nova tarefa: cria instâncias dos objetos necessários, define os atributos da tarefa e chama o método de inserção.
    $tarefa = new Tarefa();
    $tarefa->__set('tarefa', $_POST['tarefa']);
    $tarefa->__set('categoria', $_POST['categoria']);
    $tarefa->__set('data_prazo', $_POST['data_prazo']);

    $conexao = new Conexao();
    $tarefaService = new TarefaService($conexao, $tarefa);
    $tarefaService->inserir();

    header('Location: nova_tarefa.php?inclusao=1'); // Redireciona para a página de nova tarefa com um parâmetro de sucesso.
} else if ($acao == 'recuperar') {
    // Bloco para recuperar tarefas: cria os objetos e chama o método de recuperação de tarefas.
	$tarefa = new Tarefa();
	$conexao = new Conexao();

	$tarefaService = new TarefaService($conexao, $tarefa);
	$tarefas = $tarefaService->recuperar();
} else if ($acao == 'atualizar') {
    // Bloco para atualizar uma tarefa: semelhante ao bloco de inserção, mas chama o método de atualização.
	$tarefa = new Tarefa();
	$tarefa->__set('id', $_POST['id'])->__set('tarefa', $_POST['tarefa']);

	$conexao = new Conexao();
	$tarefaService = new TarefaService($conexao, $tarefa);
	$tarefaService->atualizar();

	header('location: index.php');
} else if ($acao == 'remover') {
    // Bloco para remover uma tarefa: define o ID da tarefa e chama o método de remoção.
	$tarefa = new Tarefa();
	$tarefa->__set('id', $_GET['id']);

	$conexao = new Conexao();
	$tarefaService = new TarefaService($conexao, $tarefa);
	$tarefaService->remover();

	header('location: index.php');
} else if ($acao == 'marcarRealizada') {
    // Bloco para marcar uma tarefa como realizada: define o ID da tarefa e o status como 'Realizada', depois chama o método correspondente.
	$tarefa = new Tarefa();
	$tarefa->__set('id', $_GET['id'])->__set('id_status', 2);

	$conexao = new Conexao();
	$tarefaService = new TarefaService($conexao, $tarefa);
	$tarefaService->marcarRealizada();

	header('location: index.php');
} else if ($acao == 'filtrarPorStatus') {
    // Bloco para filtrar tarefas por status: recupera o status desejado e chama o método de filtragem correspondente.
	$status = $_GET['status'];
	$tarefa = new Tarefa();
	$conexao = new Conexao();

	$tarefaService = new TarefaService($conexao, $tarefa);
	if ($status == 'por_data') {
		$tarefas = $tarefaService->recuperarOrdenadoPorData();
	} else {
		$tarefas = $tarefaService->filtrarTarefasPorStatus($status);
	}

	$_SESSION['tarefas_filtradas'] = $tarefas;
	header('Location: index.php');
} else if ($acao == 'filtrarPorCategoria') {
    // Bloco para filtrar tarefas por categoria: recupera a categoria desejada e chama o método de filtragem.
	$categoria_pesquisa = $_GET['categoria_pesquisa'];
	$conexao = new Conexao();
	$tarefaService = new TarefaService($conexao, new Tarefa());
	$tarefas = $tarefaService->filtrarPorCategoria($categoria_pesquisa);

	$_SESSION['tarefas_filtradas'] = $tarefas;
	header('Location: index.php');
}

?>