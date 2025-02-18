<?php

require_once '../../model/Aluno.php';
use model\Aluno;

$idAluno = $_GET['idAluno'] ?? null;
$idCurso = $_GET['idCurso'] ?? null;
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $alunos = (new Aluno())->Consultar($idAluno, $idCurso);
    
    echo json_encode($alunos);
} else {
    echo json_encode(["error" => "Falha ao chamar API"]);
}
?>