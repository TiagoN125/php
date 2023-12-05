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

// Função para adicionar resultado de exame e paciente
function adicionarResultadoExameEPaciente($conn, $tipo_exame, $resultado, $nome_paciente, $data_nascimento) {
    // Iniciar transação
    $conn->begin_transaction();

    // Preparar declarações
    $stmt1 = $conn->prepare("INSERT INTO pacientes (nome_paciente, data_nascimento) VALUES (?, ?)");
    $stmt2 = $conn->prepare("INSERT INTO resultados_exames (id_paciente, tipo_exame, resultado) VALUES (?, ?, ?)");

    // Executar declarações
    $stmt1->bind_param("sss", $nome_paciente, $data_nascimento);
    $stmt2->bind_param("isss", $id_paciente, $tipo_exame, $resultado);

    // Executar e obter o último ID de inserção para o paciente
    $stmt1->execute();
    $id_paciente = $stmt1->insert_id;

    // Adicionar o resultado do exame
    $stmt2->execute();

    // Confirmar a transação
    $conn->commit();

    echo "Resultado de exame e paciente adicionados com sucesso.";
}

// Exemplo de uso
adicionarResultadoExameEPaciente($conn, "Análise de Sangue", "Negativo", "João Silva", "1995-08-10");

// Fechar conexão
$conn->close();

?>