<?php
require_once '../../model/Matricula.php';
use model\Matricula;

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);

    $id = $data['id'] ?? null;
    
    if (isset($id)) {
        (new Matricula())->Excluir($id);
    } else {
        echo json_encode(["error" => "Insira um ID"]);
    }
} else {
    echo json_encode(["error" => "Falha ao chamar API"]);
}
?>

