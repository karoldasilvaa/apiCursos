<?php
namespace model;

require_once __DIR__ . '/../config/dataBase.php';
use config\dataBase;

require_once '../../model/Curso.php';
use model\Curso;

require_once __DIR__ . '/Autenticacao.php';
use model\Autenticacao;

class Matricula {
    public $conn;
    public $autenticacao;

    public function __construct() {
        $this->autenticacao = (new Autenticacao())->AutenticarUsuario();
    }

    public function Atualizar($id, $id_curso) {
        try {
            $this->conn = (new dataBase())->getConexao();

            $data_atualizacao = date("Y-m-d H:i:s");

            $query = 'UPDATE matricula SET id_curso = ? WHERE ID = ?';
            $stmt = $this->conn->prepare($query);
            $stmt -> bind_param('ii', $id_curso, $id);
            $stmt -> execute();
            $stmt -> close();
            $this->conn->close();

            echo json_encode(["sucess" => "Registro atualizado com sucesso"]);
        } catch(Exception $e) {
            echo json_encode(["error" => "Falha ao atualizar matricula"]);
        }    
    }

    public function Consultar($id) {
        try {
            $this->conn = (new dataBase())->getConexao();

            $matricula = [];

            if($id) {
                $query = "SELECT * FROM MATRICULA WHERE ID = ?";
                $stmt = $this->conn->prepare($query);
                $stmt->bind_param("i", $id);            
            }else{
                $query = "SELECT * FROM MATRICULA";
                $stmt = $this->conn->prepare($query);            
            }

            $stmt->execute();

            $resultado = $stmt->get_result();
            $matricula = $resultado->fetch_all(MYSQLI_ASSOC);

            $stmt->close();
            $this->conn->close();

            return $matricula;
        } catch(Exception $e) {
            echo json_encode(["error" => "Falha ao consultar matricula"]);
        }    
    }

    public function Excluir($id) {
        try {
            $this->conn = (new dataBase())->getConexao();

            $query = 'DELETE FROM matricula WHERE ID = ?;';
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
            $this->conn->close();

            echo json_encode(["sucess" => "Registro excluido com sucesso"]);
        } catch(Exception $e) {
            echo json_encode(["error" => "Falha ao excluir matricula"]);
        }
    }

    public function Gravar($id_aluno, $id_curso) {

        try {  
            $curso = (new Curso())->Consultar($id_curso, $id_aluno);

            if($curso) {
                echo json_encode(["error" => "Esse aluno ja esta matriculado nesse curso"]);
            } else {
                $this->conn = (new dataBase())->getConexao();

                $data_matricula = date("Y-m-d H:i:s");
    
                $query = 'insert into matricula (id_aluno, id_curso, data_matricula) values (?,?,?)';
        
                $stmt = $this->conn->prepare($query);
        
                $stmt->bind_param("iis", $id_aluno, $id_curso, $data_matricula);  
    
                $stmt->execute();
        
                $stmt->close();
                $this->conn->close();
        
                echo json_encode(["success" => "Registro gravado com sucesso"]);
            }

        } catch(Exception $e) {
            echo json_encode(["error" => "Falha ao gravar matricula"]);
        }
    }
}
?>