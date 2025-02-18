<?php

namespace model;

require_once __DIR__ . '/Usuario.php';
use model\Usuario;

class Autenticacao {
    public function AutenticarUsuario() {
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Origin: *");

        if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
            header('HTTP/1.1 401 Não autorizado');
            header('WWW-Authenticate: Basic realm="Acesso à API"');
            echo json_encode(["erro" => "É necessário informar usuário e senha"]);
            exit;
        }

        $verificado = (new Usuario())->Consultar($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);

        if (!$verificado) {
            header('HTTP/1.1 401 Não autorizado');
            echo json_encode(["erro" => "Usuário ou senha inválidos"]);
            exit;
        } 
    }
}
