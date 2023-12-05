<?php
function conectar() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "insercaodedados";

    try {
        // Estabelece a conexão com o banco de dados usando PDO
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        echo "Erro: " . $e->getMessage();
        return null;
    }
}

function criarTabelas($conexao) {
    $sqlUsuarios = "CREATE TABLE IF NOT EXISTS usuarios (
                      id_usuario INT AUTO_INCREMENT,
                      nome VARCHAR(100) NOT NULL,
                      email VARCHAR(100) NOT NULL,
                      PRIMARY KEY (id_usuario)
                 )";

    $sqlPedidos = "CREATE TABLE IF NOT EXISTS pedidos (
                      id_pedido INT AUTO_INCREMENT,
                      id_usuario INT NOT NULL,
                      produto VARCHAR(100) NOT NULL,
                      quantidade INT NOT NULL,
                      PRIMARY KEY (id_pedido),
                      FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
                 )";

    try {
        $conexao->exec($sqlUsuarios);
        $conexao->exec($sqlPedidos);
        echo "Tabelas criadas com sucesso.";
    } catch(PDOException $e) {
        echo "Erro ao criar tabelas: " . $e->getMessage();
    }
}

function inserirDados($conexao) {
    try {
        // Inserção de dados na tabela usuarios
        $sqlUsuario = "INSERT INTO usuarios (nome, email) VALUES (:nome, :email)";
        $stmtUsuario = $conexao->prepare($sqlUsuario);

        // Define os valores dos parâmetros
        $nome = "Tiago Nunes";
        $email = "tiagonunes@email.com";
        $stmtUsuario->bindParam(':nome', $nome);
        $stmtUsuario->bindParam(':email', $email);
        $stmtUsuario->execute();

        // Recupera o id_usuario inserido
        $id_usuario = $conexao->lastInsertId();

        // Inserção de dados na tabela pedidos
        $sqlPedido = "INSERT INTO pedidos (id_usuario, produto, quantidade) VALUES (:id_usuario, :produto, :quantidade)";
        $stmtPedido = $conexao->prepare($sqlPedido);

        // Define os valores dos parâmetros
        $produto = "Teclado";
        $quantidade = 1;
        $stmtPedido->bindParam(':id_usuario', $id_usuario);
        $stmtPedido->bindParam(':produto', $produto);
        $stmtPedido->bindParam(':quantidade', $quantidade);
        $stmtPedido->execute();

        echo "Dados inseridos com sucesso.";
    } catch(PDOException $e) {
        echo "Erro ao inserir dados: " . $e->getMessage();
    }
}

$conexao = conectar();

if ($conexao) {
    criarTabelas($conexao);
    inserirDados($conexao);
    $conexao = null; // Fecha a conexão
}
?>

