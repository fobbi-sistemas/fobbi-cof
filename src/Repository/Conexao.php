<?php

namespace Src\Repository;

use Src\Util\AppConfig;
use PDO;
use PDOException;

date_default_timezone_set('America/Sao_Paulo');

class Conexao
{

    private $usuario;
    private $senha;
    private $banco;
    private $servidor;
    private static $pdo;

    public function __construct()
    {
        $this->servidor = AppConfig::get('db_host', 'localhost:3306');
        $this->banco = AppConfig::get('db_name', 'fobbi');
        $this->usuario = AppConfig::get('db_user', 'root');
        $this->senha = AppConfig::get('db_pass', 'root');
    }

    public function conectar()
    {
        try {
            if (is_null(self::$pdo)) {
                self::$pdo = new PDO("mysql:host=" . $this->servidor . ";dbname=" . $this->banco, $this->usuario, $this->senha);
                self::$pdo->query("SET NAMES 'utf8'");
                self::$pdo->query('SET character_set_connection=utf8');
                self::$pdo->query('SET character_set_client=utf8');
                self::$pdo->query('SET character_set_results=utf8');
            }
            return self::$pdo;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
}

?>
