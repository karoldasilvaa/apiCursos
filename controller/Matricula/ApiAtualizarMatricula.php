<?php
require_once '../../model/Matricula.php';
use model\Matricula;

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id'] ?? null;
    $id_curso = $data['id_curso'] ?? null;

    if (isset($id) && isset($id_curso)) {
        (new Matricula())->Atualizar($id, $id_curso);
    } else {
        echo json_encode(["error" => "Insira todos os parâmetros"]);
    }
    
} else {
    echo json_encode(["error" => "Falha ao chamar API"]);
}
?>