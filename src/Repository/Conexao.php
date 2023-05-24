<?php

namespace Src\Repository;

use Src\Util\ProjectStage;
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
        $projectStage = new ProjectStage();

        if ($projectStage->currentStage() == "DEVELOPMENT") {
            $this->servidor = "hsys_fobbi.mysql.dbaas.com.br";
            $this->banco = "hsys_fobbi";
            $this->usuario = "hsys_fobbi";
            $this->senha = "Hsys58si23@";
        } elseif ($projectStage->currentStage() == "PRODUCTION") {
            $this->servidor = "localhost";
            $this->banco = "fobbi";
            $this->usuario = "ftpadmin";
            $this->senha = "fkfgj@34hjf2";
        }
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