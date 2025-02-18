<?php

require_once '../../model/Aluno.php';
use model\Aluno;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $nome = $data['nome'] ?? null;
    $email = $data['email'] ?? null;

    if (isset($nome) && isset($email)) {
        (new Aluno())->Gravar($nome, $email);
    } else {
        echo json_encode(["error" => "Insira todos os parâmetros"]);
    }

} else {
    echo json_encode(["error" => "Falha ao chamar API"]);
}
?>