<?php

// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "sua_senha";
$dbname = "seu_banco_de_dados";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Função para adicionar livro e autor
function adicionarLivroEAutor($conn, $titulo, $ano_publicacao, $nome_autor) {
    // Iniciar transação
    $conn->begin_transaction();

    // Preparar declarações
    $stmt1 = $conn->prepare("INSERT INTO livros (titulo, ano_publicacao) VALUES (?, ?)");
    $stmt2 = $conn->prepare("INSERT INTO autores (nome_autor) VALUES (?)");

    // Executar declarações
    $stmt1->bind_param("sis", $titulo, $ano_publicacao);
    $stmt2->bind_param("s", $nome_autor);

    // Executar e obter o último ID de inserção para o livro
    $stmt1->execute();
    $last_insert_id = $stmt1->insert_id;

    // Executar a declaração para inserir o autor
    $stmt2->execute();

    // Confirmar a transação
    $conn->commit();

    echo "Livro e autor adicionados com sucesso.";
}

// Exemplo de uso
adicionarLivroEAutor($conn, "O Senhor dos Anéis", 1954, "J.R.R. Tolkien");

// Fechar conexão
$conn->close();

?>