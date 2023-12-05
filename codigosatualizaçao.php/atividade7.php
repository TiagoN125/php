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

// Função para adicionar fornecedor e compra
function adicionarFornecedorECompra($conn, $nome, $contato, $produto_comprado, $quantidade) {
    // Iniciar transação
    $conn->begin_transaction();

    // Preparar declarações
    $stmt1 = $conn->prepare("INSERT INTO fornecedores (nome, contato) VALUES (?, ?)");
    $stmt2 = $conn->prepare("INSERT INTO compras (id_fornecedor, produto_comprado, quantidade) VALUES (?, ?, ?)");

    // Executar declarações
    $stmt1->bind_param("ss", $nome, $contato);
    $stmt2->bind_param("iss", $last_insert_id, $produto_comprado, $quantidade);

    // Executar e obter o último ID de inserção para o fornecedor
    $stmt1->execute();
    $last_insert_id = $stmt1->insert_id;

    // Executar a declaração para inserir a compra
    $stmt2->execute();

    // Confirmar a transação
    $conn->commit();

    echo "Fornecedor e compra adicionados com sucesso.";
}

// Exemplo de uso
adicionarFornecedorECompra($conn, "Fornecedor de Tecnologia", "fornecedor.tecnologia@email.com", "Smartphone", 50);

// Fechar conexão
$conn->close();

?>