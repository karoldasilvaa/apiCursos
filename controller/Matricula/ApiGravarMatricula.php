<?php

require_once '../../model/Matricula.php';
use model\Matricula;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id_aluno = $data['id_aluno'] ?? null;
    $id_curso = $data['id_curso'] ?? null;

    if (isset($id_aluno) && isset($id_curso)) {
        (new Matricula())->Gravar($id_aluno, $id_curso);
    } else {
        echo json_encode(["error" => "Insira todos os parâmetros"]);
    }

} else {
    echo json_encode(["error" => "Falha ao chamar API"]);
}
?>