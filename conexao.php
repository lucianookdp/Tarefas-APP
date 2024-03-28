<?php

// Definição da classe Conexao
class Conexao {
    // Propriedades privadas da classe para armazenar as credenciais de conexão ao banco de dados
    private $host = 'localhost'; // O servidor onde o banco de dados está rodando, geralmente localhost
    private $dbname = 'php_com_pdo'; // Nome do banco de dados ao qual queremos nos conectar
    private $user = 'root'; // Nome de usuário para acessar o banco de dados
    private $pass = ''; // Senha do usuário para acessar o banco de dados

    // Método público que tentará estabelecer uma conexão com o banco de dados
    public function conectar() {
        try {
            // Tentativa de criar um novo objeto PDO para gerenciar a conexão
            // PDO é uma classe PHP que representa uma conexão entre PHP e um banco de dados
            $conexao = new PDO(
                "mysql:host=$this->host;dbname=$this->dbname", // DSN (Data Source Name) especifica o host e o nome do banco de dados
                "$this->user", // Nome de usuário para a conexão
                "$this->pass"  // Senha para a conexão
            );

            // Retorna o objeto de conexão caso a conexão seja bem-sucedida
            return $conexao;

        } catch (PDOException $e) { // Captura qualquer exceção do tipo PDOException, que representa um erro na conexão
            // Exibe a mensagem de erro caso a conexão falhe
            echo '<p>'.$e->getMessage().'</p>';
        }
    }
}

?>
