<?php 
namespace model;

require_once __DIR__ . '/../config/dataBase.php';
use config\dataBase;

class Usuario {
    public $conn;
    
    public function Consultar($usuario, $senha) {
        try {
            $this->conn = (new dataBase())->getConexao();

            $query = "SELECT * FROM usuario_api WHERE nome = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('s', $usuario); 
            $stmt->execute();

            $resultado = $stmt->get_result();
            $usuario = $resultado->fetch_assoc();

            if ($usuario && password_verify($senha, $usuario['senha'])) {
                return $usuario;
            } else {
                return null;
            }

            $stmt->close();
            $this->conn->close();
            
        } catch (Exception $e) {
            throw new Exception("Erro ao executar query: " . $e->getMessage());
        }
    }
}
?>
