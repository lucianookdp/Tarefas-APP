<?php
session_start(); // Inicia uma nova sessão ou resume uma sessão existente

// Verifica se existe uma lista de tarefas filtradas na sessão
if (isset($_SESSION['tarefas_filtradas'])) {
	$tarefas = $_SESSION['tarefas_filtradas']; // Recupera tarefas filtradas
	unset($_SESSION['tarefas_filtradas']); // Limpa a variável de sessão para evitar reexecução
} else {
	// Define a ação como 'recuperar' se não houver tarefas filtradas
	$acao = 'recuperar';
	require 'tarefa_controller.php'; // Carrega o controlador que trata a ação de recuperar
}
?>



<html>

<html>

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>App Lista Tarefas</title>

	<link rel="stylesheet" href="css/estilo.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<script>
		function editar(id, txt_tarefa) {
			//criar um form de edição
			let form = document.createElement('form')
			form.action = 'tarefa_controller.php?acao=atualizar'
			form.method = 'post'
			form.className = 'row'

			//criar um input para entrada do texto
			let inputTarefa = document.createElement('input')
			inputTarefa.type = 'text'
			inputTarefa.name = 'tarefa'
			inputTarefa.className = 'col-9 form-control'
			inputTarefa.value = txt_tarefa

			//criar um input hidden para guardar o id da tarefa
			let inputId = document.createElement('input')
			inputId.type = 'hidden'
			inputId.name = 'id'
			inputId.value = id

			//criar um button para envio do form
			let button = document.createElement('button')
			button.type = 'submit'
			button.className = 'col-3 btn btn-info'
			button.innerHTML = 'Atualizar'

			//incluir inputTarefa no form
			form.appendChild(inputTarefa)

			//incluir inputId no form
			form.appendChild(inputId)

			//incluir button no form
			form.appendChild(button)

			//selecionar a div tarefa
			let tarefa = document.getElementById('tarefa_' + id)

			//limpar o texto da tarefa para inclusão do form
			tarefa.innerHTML = ''

			//incluir form na página
			tarefa.insertBefore(form, tarefa[0])
		}

		function remover(id) {
			location.href = 'tarefa_controller.php?acao=remover&id=' + id;
		}

		function marcarRealizada(id) {
			location.href = 'tarefa_controller.php?acao=marcarRealizada&id=' + id;
		}
	</script>

</head>

<body>
	<nav class="navbar navbar-light bg-light">
		<div class="container">
			<a class="navbar-brand" href="#">
				<img src="img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
				App Lista Tarefas
			</a>
		</div>
	</nav>

	<div class="container app">
		<div class="row">
			<div class="col-md-3 menu">
				<ul class="list-group">
					<li class="list-group-item active"><a href="index.php">Tarefas</a></li>
					<li class="list-group-item"><a href="nova_tarefa.php">Nova tarefa</a></li>
					<li class="list-group-item active"><a href="arquivadas.php">Tarefas Arquivadas</a></li>
				</ul>
			</div>

			<div class="col-md-9">
				<div class="container pagina">
					<div class="row">
						<div class="col">
							<h4>Tarefas</h4>
							<hr />

							<form action="index.php" method="GET">
								<div class="form-group">
									<input type="text" name="categoria_pesquisa" class="form-control" placeholder="Pesquisar por categoria...">
								</div>
								<button type="submit" class="btn btn-primary">Pesquisar</button>
								<input type="hidden" name="acao" value="filtrarPorCategoria">
							</form>


							<div class="filtro-tarefas mb-3">
								<form action="tarefa_controller.php" method="GET">
									<input type="hidden" name="acao" value="filtrarPorStatus">
									<div class="form-group">
										<label for="filtro_status">Filtrar tarefas por:</label>
										<select name="status" id="filtro_status" class="form-control">
											<option value="todas">Todas</option>
											<option value="pendente">Pendentes</option>
											<option value="realizado">Realizadas</option>
											<option value="por_data">Data De Criação</option>
										</select>

									</div>
									<button type="submit" class="btn btn-primary">Filtrar</button>
									<button class="btn btn-outline-secondary" onclick="location.reload();">
										<i class="fas fa-sync-alt"></i>
									</button>
								</form>
							</div>


							<?php foreach ($tarefas as $indice => $tarefa) { ?>
								<div class="row mb-3 d-flex align-items-center tarefa">
									<div class="col-sm-9" id="tarefa_<?= $tarefa->id ?>">
										Tarefa: <?= $tarefa->tarefa ?>
										<div class="status-tarefa">
											Status: <?= $tarefa->status ?>
										</div>
										<!-- Inclusão da linha abaixo para exibir a categoria -->
										<div class="categoria-tarefa">
											Categoria: <?= $tarefa->categoria ?>
										</div>
										<div class="prazo-tarefa">
											Prazo: <?= date('d/m/Y', strtotime($tarefa->data_prazo)) ?>
											<?php
											$dataHoje = new DateTime();
											$dataPrazo = new DateTime($tarefa->data_prazo);
											$intervalo = $dataHoje->diff($dataPrazo);
											if ($dataHoje > $dataPrazo) {
												echo "(Expirado)";
											} else if ($intervalo->days <= 7) {
												echo "(" . $intervalo->days . " dias restantes)";
											}
											?>
										</div>
										<div class="text-muted">
											Criado em: <?= date('d/m/Y H:i', strtotime($tarefa->data_cadastrado)) ?>
										</div>

									</div>
									<div class="col-sm-3 mt-2 d-flex justify-content-between">
										<i class="fas fa-trash-alt fa-lg text-danger" onclick="remover(<?= $tarefa->id ?>)"></i>
										<i class="fas fa-edit fa-lg text-info" onclick="editar(<?= $tarefa->id ?>, '<?= addslashes($tarefa->tarefa) ?>')"></i>
										<i class="fas fa-check-square fa-lg text-success" onclick="marcarRealizada(<?= $tarefa->id ?>)"></i>
										<i class="fas fa-archive fa-lg text-secondary" onclick="" title="Arquivar tarefa"></i>
									</div>
								</div>
							<?php } ?>



						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

</html>

