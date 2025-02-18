<?php

require_once '../../model/Matricula.php';
use model\Matricula;

$id = $_GET['id'] ?? null;
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $Matriculas = (new Matricula())->Consultar($id);
    
    echo json_encode($Matriculas);
} else {
    echo json_encode(["error" => "Falha ao chamar API"]);
}
?>