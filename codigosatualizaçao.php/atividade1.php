<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "incersao_dados";

// Cria conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Criação da tabela livros
$sql = "CREATE TABLE IF NOT EXISTS livros (
    id_livro INT AUTO_INCREMENT PRIMARY KEY,
    título VARCHAR(255),
    ano_publicação VARCHAR(255)
)";

if ($conn->query($sql) === TRUE) {
    echo "Tabela livros criada com sucesso.";
} else {
    echo "Erro ao criar tabela: " . $conn->error;
}

// Criação da tabela autores
$sql = "CREATE TABLE IF NOT EXISTS autores (
    id_autor INT AUTO_INCREMENT PRIMARY KEY,
    nome_autor VARCHAR(255)
)";

if ($conn->query($sql) === TRUE) {
    echo "Tabela autores criada com sucesso.";
} else {
    echo "Erro ao criar tabela: " . $conn->error;
}

// Insere dados na tabela livros
$sql = "INSERT INTO livros (id_livro, título, ano_publicação) VALUES (1, 'Aprendendo Python', '2020')";

if ($conn->query($sql) === TRUE) {
    echo "Dados inseridos na tabela livros com sucesso.";
} else {
    echo "Erro ao inserir dados: " . $conn->error;
}

// Insere dados na tabela autores
$sql = "INSERT INTO autores (id_autor, nome_autor) VALUES (1, 'Carlos Silva')";

if ($conn->query($sql) === TRUE) {
    echo "Dados inseridos na tabela autores com sucesso.";
} else {
    echo "Erro ao inserir dados: " . $conn->error;
}

$conn->close();

?>