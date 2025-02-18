<?php

require_once '../../model/Curso.php';
use model\Curso;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $nome = $data['nome'] ?? null;
    $descricao = $data['descricao'] ?? null;
    $duracao = $data['duracao'] ?? null;

    if (isset($nome) && isset($descricao) && isset($duracao)) {
        (new Curso())->Gravar($nome, $descricao, $duracao);
    } else {
        echo json_encode(["error" => "Insira todos os parâmetros"]);
    }

} else {
    echo json_encode(["error" => "Falha ao chamar API"]);
}
?>