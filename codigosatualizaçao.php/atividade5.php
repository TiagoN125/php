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

// Função para adicionar cliente e venda
function adicionarClienteEVenda($conn, $nome, $email, $produto_vendido, $valor) {
    // Iniciar transação
    $conn->begin_transaction();

    // Preparar declarações
    $stmt1 = $conn->prepare("INSERT INTO clientes (nome, email) VALUES (?, ?)");
    $stmt2 = $conn->prepare("INSERT INTO vendas (id_cliente, produto_vendido, valor) VALUES (?, ?, ?)");

    // Executar declarações
    $stmt1->bind_param("ss", $nome, $email);
    $stmt2->bind_param("iss", $last_insert_id, $produto_vendido, $valor);

    // Executar e obter o último ID de inserção para o cliente
    $stmt1->execute();
    $last_insert_id = $stmt1->insert_id;

    // Executar a declaração para inserir a venda
    $stmt2->execute();

    // Confirmar a transação
    $conn->commit();

    echo "Cliente e venda adicionados com sucesso.";
}

// Exemplo de uso
adicionarClienteEVenda($conn, "João Silva", "joao.silva@email.com", "Smartphone", 2500);

// Fechar conexão
$conn->close();

?>