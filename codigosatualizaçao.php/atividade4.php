<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'seu_nome_de_usuario');
define('DB_PASSWORD', 'sua_senha');
define('DB_NAME', 'insercaodedados');

// Criar conexão
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Função para adicionar produto e categoria
function adicionarProdutoECategoria($conn, $nome_produto, $preco_produto, $nome_categoria) {
    // Iniciar transação
    $conn->begin_transaction();

    // Preparar declarações
    $stmt1 = $conn->prepare("INSERT INTO categorias (nome_categoria) VALUES (?)");
    $stmt2 = $conn->prepare("INSERT INTO produtos (nome_produto, preco, id_categoria) VALUES (?, ?, ?)");

    // Executar declarações
    $stmt1->bind_param("s", $nome_categoria);
    $stmt1->execute();

    // Obter o último ID de inserção para a categoria
    $last_insert_id = $stmt1->insert_id;

    // Executar a declaração para inserir o produto
    $stmt2->bind_param("sdi", $nome_produto, $preco_produto, $last_insert_id);
    $stmt2->execute();

    // Confirmar a transação
    $conn->commit();

    echo "Produto e Categoria adicionados com sucesso.";
}

// Função para exibir produtos e categorias
function exibirProdutosECategorias($conn) {
    $sql = "SELECT produtos.nome_produto, produtos.preco, categorias.nome_categoria
            FROM produtos
            INNER JOIN categorias ON produtos.id_categoria = categorias.id_categoria";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Saída de dados de cada linha
        while ($row = $result->fetch_assoc()) {
            echo "Produto: " . $row["nome_produto"] . " - Preço: " . $row["preco"] . " - Categoria: " . $row["nome_categoria"] . "<br>";
        }
    } else {
        echo "0 resultados";
    }
}

// Exemplo de uso
adicionarProdutoECategoria($conn, "Mouse", 150, "Periféricos");
exibirProdutosECategorias($conn);

// Fechar conexão
$conn->close();
?>
