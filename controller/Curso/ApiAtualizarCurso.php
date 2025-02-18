<?php
require_once '../../model/Curso.php';
use model\Curso;

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id'] ?? null;
    $nome = $data['nome'] ?? null;
    $descricao = $data['descricao'] ?? null;
    $duracao = $data['duracao'] ?? null;

    if (isset($id) && isset($nome) && isset($descricao) && isset($duracao)) {
        (new Curso())->Atualizar($id, $nome, $descricao, $duracao);
    } else {
        echo json_encode(["error" => "Insira todos os parâmetros"]);
    }
    
} else {
    echo json_encode(["error" => "Falha ao chamar API"]);
}
?>