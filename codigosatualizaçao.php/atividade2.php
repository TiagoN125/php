<?php

require_once "conexao.php";

function criarTabelas($conexao) {
    // Criação da tabela alunos
    $sql = "CREATE TABLE IF NOT EXISTS alunos (
                id_aluno INT AUTO_INCREMENT PRIMARY KEY,
                nome VARCHAR(255),
                turma VARCHAR(255)
            )";

    // Executa a instrução SQL para criar a tabela alunos
    if ($conexao->query($sql) === TRUE) {
        echo "Tabela alunos criada com sucesso.";
    } else {
        echo "Erro ao criar a tabela alunos: " . $conexao->error;
    }

    // Criação da tabela cursos
    $sql = "CREATE TABLE IF NOT EXISTS cursos (
                id_curso INT AUTO_INCREMENT PRIMARY KEY,
                nome_curso VARCHAR(255),
                instrutor VARCHAR(255)
            )";

    // Executa a instrução SQL para criar a tabela cursos
    if ($conexao->query($sql) === TRUE) {
        echo "Tabela cursos criada com sucesso.";
    } else {
        echo "Erro ao criar a tabela cursos: " . $conexao->error;
    }
}

function inserirDados($conexao) {
    // SQL para inserir dados na tabela alunos
    $sqlAluno = "INSERT INTO alunos (id_aluno, nome, turma) VALUES (?, ?, ?)";

    // Prepara o comando SQL
    $stmtAluno = $conexao->prepare($sqlAluno);

    // Define os valores dos parâmetros
    $stmtAluno->bind_param("iss", $id_aluno, $nome, $turma);

    // Inserção de dados na tabela alunos
    $id_aluno = 1;
    $nome = "Lucas";
    $turma = "Turma A";
    $stmtAluno->execute();

    $id_aluno = 2;
    $nome = "Julia";
    $turma = "Turma B";
    $stmtAluno->execute();

    // SQL para inserir dados na tabela cursos
    $sqlCurso = "INSERT INTO cursos (id_curso, nome_curso, instrutor) VALUES (?, ?, ?)";

    // Prepara o comando SQL
    $stmtCurso = $conexao->prepare($sqlCurso);

    // Define os valores dos parâmetros
    $stmtCurso->bind_param("iss", $id_curso, $nome_curso, $instrutor);

    // Inserção de dados na tabela cursos
    $id_curso = 1;
    $nome_curso = "Matematica";
   