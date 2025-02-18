<?php

require_once '../../model/Curso.php';
use model\Curso;

$idCurso = $_GET['idCurso'] ?? null;
$idAluno = $_GET['idAluno'] ?? null;
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $Cursos = (new Curso())->Consultar($idCurso, $idAluno);
    
    echo json_encode($Cursos);
} else {
    echo json_encode(["error" => "Falha ao chamar API"]);
}
?>