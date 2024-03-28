<html>
<head>
    <!-- Define a codificação de caracteres e a compatibilidade com dispositivos móveis -->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Título da página -->
	<title>App Lista Tarefas</title>
	<!-- Links para as folhas de estilo do Bootstrap e FontAwesome para estilização e ícones -->
	<link rel="stylesheet" href="css/estilo.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
</head>
<body>
    <!-- Barra de navegação superior usando componentes do Bootstrap -->
	<nav class="navbar navbar-light bg-light">
		<div class="container">
			<!-- Logotipo e nome do app na barra de navegação -->
			<a class="navbar-brand" href="#">
				<img src="img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
				App Lista Tarefas
			</a>
		</div>
	</nav>

	<!-- Mensagem de feedback para o usuário após a inserção de uma tarefa -->
	<?php if (isset($_GET['inclusao']) && $_GET['inclusao'] == 1) { ?>
		<div class="bg-success pt-2 text-white d-flex justify-content-center">
			<h5>Tarefa inserida com sucesso!</h5>
		</div>
	<?php } ?>

	<!-- Estrutura principal da página -->
	<div class="container app">
		<div class="row">
		    <!-- Menu lateral com links para diferentes seções do aplicativo -->
			<div class="col-md-3 menu">
				<ul class="list-group">
					<li class="list-group-item"><a href="index.php">Tarefas pendentes</a></li>
					<li class="list-group-item active"><a href="#">Nova tarefa</a></li>
					<li class="list-group-item"><a href="arquivadas.php">Tarefas Arquivadas</a></li>
				</ul>
			</div>

			<!-- Área principal para adicionar novas tarefas -->
			<div class="col-md-9">
				<div class="container pagina">
					<div class="row">
						<div class="col">
							<h4>Nova tarefa</h4>
							<hr />
							<!-- Formulário para inserção de uma nova tarefa -->
							<form method="post" action="tarefa_controller.php?acao=inserir">
								<div class="form-group">
									<!-- Campo para descrição da tarefa -->
									<label>Descrição da tarefa:</label>
									<input type="text" class="form-control" name="tarefa" placeholder="Exemplo: Lavar o carro">
									<!-- Campo para categoria da tarefa -->
									<br>
									<label>Categoria:</label>
									<input type="text" class="form-control" name="categoria" placeholder="Exemplo: Lazer">
									<!-- Campo para definir o prazo final da tarefa -->
									<br>
									<label>Prazo Final:</label>
									<input type="date" class="form-control" name="data_prazo" required>
								</div>
								<!-- Botão para submeter o formulário -->
								<button class="btn btn-success">Cadastrar</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
