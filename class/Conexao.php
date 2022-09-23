<?php
include_once "ProjectStage.php";

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
            $this->servidor = "localhost:3306";
            $this->banco = "fobbi-site";
            $this->usuario = "root";
            $this->senha = "root";
        } else if ($projectStage->currentStage() == "PRODUCTION") {
            $this->servidor = "fobbi_site.mysql.dbaas.com.br";
            $this->banco = "fobbi_site";
            $this->usuario = "fobbi_site";
            $this->senha = "Hsys58si21@";
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