<?php

// Definindo a classe TarefaService para realizar operações CRUD em tarefas
class TarefaService
{

	private $conexao; // Propriedade para armazenar a conexão com o banco de dados
	private $tarefa; // Propriedade para armazenar uma instância da classe Tarefa

	// Construtor para inicializar as propriedades com os objetos Conexao e Tarefa
	public function __construct(Conexao $conexao, Tarefa $tarefa)
	{
		$this->conexao = $conexao->conectar(); // Estabelecendo conexão com o banco de dados
		$this->tarefa = $tarefa; // Armazenando a referência da tarefa
	}

	// Método para inserir uma nova tarefa no banco de dados
	public function inserir()
	{
		// Preparando a consulta SQL para inserção
		$query = 'INSERT INTO tb_tarefas(tarefa, categoria, data_prazo) VALUES (:tarefa, :categoria, :data_prazo)';
		$stmt = $this->conexao->prepare($query);
		// Vinculando os valores da tarefa
		$stmt->bindValue(':tarefa', $this->tarefa->__get('tarefa'));
		$stmt->bindValue(':categoria', $this->tarefa->__get('categoria'));
		$stmt->bindValue(':data_prazo', $this->tarefa->__get('data_prazo'));
		$stmt->execute(); // Executando a consulta
	}

	// Método para filtrar tarefas por status
	public function filtrarTarefasPorStatus($status)
	{
		if ($status == 'todas') {
			// Seleciona todas as tarefas se o status for 'todas'
			$query = "SELECT t.id, s.status, t.tarefa, t.categoria, t.data_cadastrado, t.data_prazo FROM tb_tarefas as t LEFT JOIN tb_status as s on (t.id_status = s.id)";
		} else {
			// Filtra tarefas por status específico
			$query = "SELECT t.id, s.status, t.tarefa, t.categoria, t.data_cadastrado, t.data_prazo FROM tb_tarefas as t LEFT JOIN tb_status as s on (t.id_status = s.id) WHERE s.status = :status";
		}

		$stmt = $this->conexao->prepare($query);

		if ($status != 'todas') {
			$stmt->bindValue(':status', $status); // Vincula o status à consulta, se aplicável
		}

		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ); // Retorna os resultados como objetos
	}

	// Método para recuperar tarefas com ordenação específica
	public function recuperar($ordenacao = 'mais_recentes')
	{
		$ordemSql = $ordenacao == 'mais_recentes' ? 'DESC' : 'ASC'; // Define a ordem da consulta
		$query = "
        SELECT 
            t.id, t.tarefa, t.categoria, s.status, t.data_cadastrado, t.data_prazo
        FROM 
            tb_tarefas AS t
        JOIN 
            tb_status AS s ON t.id_status = s.id
        ORDER BY 
            t.data_cadastrado $ordemSql
    ";
		$stmt = $this->conexao->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}

	// Método para atualizar os detalhes de uma tarefa
	public function atualizar()
	{
		$query = "update tb_tarefas set tarefa = ? where id = ?";
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(1, $this->tarefa->__get('tarefa'));
		$stmt->bindValue(2, $this->tarefa->__get('id'));
		return $stmt->execute(); // Retorna true se a atualização for bem-sucedida
	}

	// Método para remover uma tarefa pelo ID
	public function remover()
	{
		$query = 'delete from tb_tarefas where id = :id';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':id', $this->tarefa->__get('id'));
		$stmt->execute(); // Executa a remoção
	}

	// Método para marcar uma tarefa como realizada
	public function marcarRealizada()
	{
		$query = "update tb_tarefas set id_status = ? where id = ?";
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(1, $this->tarefa->__get('id_status'));
		$stmt->bindValue(2, $this->tarefa->__get('id'));
		return $stmt->execute(); // Retorna true se a atualização for bem-sucedida
	}

	// Método para recuperar tarefas pendentes
	public function recuperarTarefasPendentes()
	{
		$query = '
			SELECT 
				t.id, s.status, t.tarefa, t.categoria, t.data_cadastrado 
			FROM 
				tb_tarefas as t
			LEFT JOIN tb_status as s on (t.id_status = s.id)
			WHERE
				t.id_status = :id_status
		';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':id_status', $this->tarefa->__get('id_status'));
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}

	// Método para filtrar tarefas por categoria
	public function filtrarPorCategoria($categoria)
	{
		$query = "
			SELECT 
				t.id, t.tarefa, t.categoria, s.status, t.data_cadastrado, t.data_prazo
			FROM 
				tb_tarefas AS t
			LEFT JOIN 
				tb_status AS s ON t.id_status = s.id
			WHERE 
				t.categoria LIKE :categoria
			ORDER BY 
				t.data_cadastrado DESC
		";
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':categoria', '%' . $categoria . '%');
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}

	// Método para recuperar tarefas ordenadas por data de cadastro
	public function recuperarOrdenadoPorData()
	{
		$query = "
			SELECT 
				t.id, t.tarefa, t.categoria, s.status, t.data_cadastrado, t.data_prazo
			FROM 
				tb_tarefas AS t
			JOIN 
				tb_status AS s ON t.id_status = s.id
			ORDER BY 
				t.data_cadastrado DESC
		";
		$stmt = $this->conexao->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}
}

