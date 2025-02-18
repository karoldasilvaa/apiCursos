<?php
namespace config;

class dataBase {
    function getConexao() {
        $hostname = "localhost";
        $bancoDados = "cursos";
        $usuario = "root";
        $senha = "";

        // Adicionando a barra invertida para usar mysqli no namespace global
        $con = new \mysqli($hostname, $usuario, $senha, $bancoDados);

        if ($con->connect_error) {
            die("Erro de conexão: " . $con->connect_error);
        }

        return $con;
    }
}
?>
