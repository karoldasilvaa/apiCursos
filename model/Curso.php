<?php
namespace model;

require_once __DIR__ . '/../config/dataBase.php';
use config\dataBase;

require_once __DIR__ . '/Autenticacao.php';
use model\Autenticacao;

class Curso {
    public $conn;
    public $autenticacao;

    public function __construct() {
        $this->autenticacao = (new Autenticacao())->AutenticarUsuario();
    }

    public function Atualizar($id, $nome, $descricao, $duracao) {
        try {
            $this->conn = (new dataBase())->getConexao();

            $data_atualizacao = date("Y-m-d H:i:s");

            $query = 'UPDATE curso SET nome = ?, descricao = ?, duracao = ?,data_atualizacao = ? WHERE ID = ?';
            $stmt = $this->conn->prepare($query);
            $stmt -> bind_param('ssisi', $nome, $descricao, $duracao, $data_atualizacao, $id);
            $stmt -> execute();
            $stmt -> close();
            $this->conn->close();

            echo json_encode(["sucess" => "Registro atualizado com sucesso"]);
        } catch(Exception $e) {
            echo json_encode(["error" => "Falha ao atualizar curso"]);
        }    
    }

    public function Consultar($idCurso, $idAluno) {
        try {
            $this->conn = (new dataBase())->getConexao();

            $curso = [];

            if($idAluno) {
                $query = "SELECT 
                c.*, a.nome 'aluno' FROM curso c
                inner join matricula m
                on m.id_curso = c.id
                inner join aluno a
                on a.id = m.id_aluno
                where a.id = ?";

                if($idCurso) {
                    $query = $query . " AND c.id = ?";
                    $stmt = $this->conn->prepare($query);
                    $stmt->bind_param("ii", $idAluno, $idCurso);   
                } else {
                    $stmt = $this->conn->prepare($query);
                    $stmt->bind_param("i", $idAluno);   
                }  
                                           
            }elseif($idCurso) {
                $query = "SELECT * FROM CURSO WHERE ID = ?";
                $stmt = $this->conn->prepare($query);
                $stmt->bind_param("i", $idCurso); 
            }else{
                $query = "SELECT * FROM CURSO";
                $stmt = $this->conn->prepare($query);            
            }

            $stmt->execute();

            $resultado = $stmt->get_result();
            $curso = $resultado->fetch_all(MYSQLI_ASSOC);

            $stmt->close();
            $this->conn->close();

            return $curso;
        } catch(Exception $e) {
            echo json_encode(["error" => "Falha ao consultar curso"]);
        }    
    }

    public function Excluir($id) {
        try {
            $this->conn = (new dataBase())->getConexao();

            $query = 'DELETE FROM curso WHERE ID = ?;';
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
            $this->conn->close();

            echo json_encode(["sucess" => "Registro excluido com sucesso"]);
        } catch(Exception $e) {
            echo json_encode(["error" => "Falha ao excluir curso"]);
        }
    }

    public function Gravar($nome, $descricao, $duracao) {

        try {
            $this->conn = (new dataBase())->getConexao();

            $data_criacao = date("Y-m-d H:i:s");
    
            $query = 'insert into curso (nome, descricao, duracao, data_criacao) values (?,?,?,?)';
    
            $stmt = $this->conn->prepare($query);
    
            $stmt->bind_param("ssis", $nome, $descricao, $duracao, $data_criacao);
            $stmt->execute();
    
            $stmt->close();
            $this->conn->close();
    
            echo json_encode(["success" => "Registro gravado com sucesso"]);
        } catch(Exception $e) {
            echo json_encode(["error" => "Falha ao gravar curso"]);
        }
    }
}
?>