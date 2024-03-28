<?php

// Define a classe Tarefa.
class Tarefa {
    // Propriedades privadas da classe, não acessíveis diretamente fora da classe.
	private $id; // ID único para a tarefa.
	private $id_status; // Status da tarefa (por exemplo, pendente, completada).
	private $tarefa; // Descrição da tarefa.
	private $data_cadastro; // Data em que a tarefa foi cadastrada.
	private $categoria; // Categoria da tarefa (por exemplo, trabalho, pessoal).
	private $data_prazo; // Data limite para a conclusão da tarefa.
	private $arquivadas; // Indica se a tarefa está arquivada.

    // Método mágico para obter o valor de uma propriedade.
	public function __get($atributo) {
		return $this->$atributo;
	}

    // Método mágico para definir o valor de uma propriedade e permite encadeamento de métodos.
	public function __set($atributo, $valor) {
		$this->$atributo = $valor;
		return $this; // Retorna a própria instância da classe para permitir encadeamento.
	}
}


