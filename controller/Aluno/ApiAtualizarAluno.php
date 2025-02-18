<?php
require_once '../../model/Aluno.php';
use model\Aluno;

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id'] ?? null;
    $nome = $data['nome'] ?? null;
    $email = $data['email'] ?? null;

    if (isset($id) && isset($nome) && isset($email)) {
        (new Aluno())->Atualizar($id, $nome, $email);
    } else {
        echo json_encode(["error" => "Insira todos os parâmetros"]);
    }
    
} else {
    echo json_encode(["error" => "Falha ao chamar API"]);
}
?>