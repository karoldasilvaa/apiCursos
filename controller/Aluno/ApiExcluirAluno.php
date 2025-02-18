<?php
require_once '../../model/Aluno.php';
use model\Aluno;

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);

    $id = $data['id'] ?? null;
    
    if (isset($id)) {
        (new Aluno())->Excluir($id);
    } else {
        echo json_encode(["error" => "Insira um ID"]);
    }
} else {
    echo json_encode(["error" => "Falha ao chamar API"]);
}
?>

