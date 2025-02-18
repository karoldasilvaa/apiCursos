<?php
namespace model;

require_once __DIR__ . '/../config/dataBase.php';
use config\dataBase;

require_once __DIR__ . '/Autenticacao.php';
use model\Autenticacao;

class Aluno {
    public $conn;
    public $autenticacao;

    public function __construct() {
        $this->autenticacao = (new Autenticacao())->AutenticarUsuario();
    }

    public function Atualizar($id, $nome, $email) {
        try {
            $this->conn = (new dataBase())->getConexao();

            $data_atualizacao = date("Y-m-d H:i:s");

            $query = 'UPDATE aluno SET nome = ?, email = ?, data_atualizacao = ? WHERE ID = ?';
            $stmt = $this->conn->prepare($query);
            $stmt -> bind_param('sssi', $nome, $email, $data_atualizacao, $id);
            $stmt -> execute();
            $stmt -> close();
            $this->conn->close();

            echo json_encode(["sucess" => "Registro atualizado com sucesso"]);
        } catch(Exception $e) {
            echo json_encode(["error" => "Falha ao atualizar aluno"]);
        }    
    }

    public function Consultar($idAluno, $idCurso) {
        try {
            $this->conn = (new dataBase())->getConexao();

            $aluno = [];

            if ($idAluno) {
                $query = "SELECT 
                a.*, c.nome 'curso'
                FROM aluno a
                INNER JOIN matricula m 
                ON m.id_aluno = a.id
                INNER JOIN curso c
                ON m.id_curso = c.id
                WHERE a.id = ?";    

                if ($idCurso) {
                    $query = $query . " AND c.id = ?
                    ORDER BY a.nome";
                    $stmt = $this->conn->prepare($query);
                    $stmt->bind_param("ii", $idAluno, $idCurso); 
                }else {
                    $stmt = $this->conn->prepare($query);
                    $stmt->bind_param("i", $idAluno); 
                } 
            }else {
                $query = "SELECT * FROM ALUNO";
                $stmt = $this->conn->prepare($query);            
            }

            $stmt->execute();

            $resultado = $stmt->get_result();
            $aluno = $resultado->fetch_all(MYSQLI_ASSOC);

            $stmt->close();
            $this->conn->close();

            return $aluno;
        } catch(Exception $e) {
            echo json_encode(["error" => "Falha ao consultar aluno"]);
        }    
    }

    public function Excluir($id) {
        try {
            $this->conn = (new dataBase())->getConexao();

            $query = 'DELETE FROM aluno WHERE ID = ?;';
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
            $this->conn->close();

            echo json_encode(["sucess" => "Registro excluído com sucesso"]);
        } catch(Exception $e) {
            echo json_encode(["error" => "Falha ao excluir aluno"]);
        }
    }

    public function Gravar($nome, $email) {

        try {
            $this->conn = (new dataBase())->getConexao();

            $data_criacao = date("Y-m-d H:i:s");
    
            $query = 'insert into aluno (nome, email, data_criacao) values (?,?,?)';
    
            $stmt = $this->conn->prepare($query);
    
            $stmt->bind_param("sss", $nome, $email, $data_criacao);
            $stmt->execute();
    
            $stmt->close();
            $this->conn->close();
    
            echo json_encode(["success" => "Registro gravado com sucesso"]);
        } catch(Exception $e) {
            echo json_encode(["error" => "Falha ao gravar aluno"]);
        }
    }
}
?>