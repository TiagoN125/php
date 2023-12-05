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

// Função para adicionar evento e participantes
function adicionarEventoEParticipantes($conn, $nome_evento, $data, $nome_participantes) {
    // Iniciar transação
    $conn->begin_transaction();

    // Preparar declarações
    $stmt1 = $conn->prepare("INSERT INTO eventos (nome_evento, data) VALUES (?, ?)");
    $stmt2 = $conn->prepare("INSERT INTO participantes (id_evento, nome_participante) VALUES (?, ?)");

    // Executar declarações
    $stmt1->bind_param("sss", $nome_evento, $data);
    $stmt2->bind_param("iss", $id_evento, $nome_participante);

    // Executar e obter o último ID de inserção para o evento
    $stmt1->execute();
    $id_evento = $stmt1->insert_id;

    // Adicionar todos os participantes
    foreach ($nome_participantes as $nome_participante) {
        $stmt2->execute();
    }

    // Confirmar a transação
    $conn->commit();

    echo "Evento e participantes adicionados com sucesso.";
}

// Exemplo de uso
adicionarEventoEParticipantes($conn, "Encontro de Amigos", "2022-03-15", ["João", "Maria", "Carlos"]);

// Fechar conexão
$conn->close();

?>