<?php

namespace Src\Exception;

use Src\Repository\Conexao;
use Exception;
use PDO;

class MyException extends Exception {
    
    // Redefine a exceção de forma que a mensagem não seja opcional
    public function __construct($message, $code = 0, Exception $previous = null) {
        // imprimir erro no arquivo de logs
        error_log($message);
        // inicia conexao com banco de dados
        $this->con = new Conexao();
        // grava exception no banco de dados
        $this->inserir($message);
        // garante que tudo está corretamente inicializado
        parent::__construct($message, $code, $previous);
    }
    
    // personaliza a apresentação do objeto como string
    public function __toString() {
        return  __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
    
    public function customFunction() {
        echo "Uma função específica desse tipo de exceção\n";
    }
    
    public function inserir($message) {
        try {
            $data = date('Y-m-d H:i:s');
            $projeto = "divek-site-manager";
            $sql = "INSERT INTO logsistema (projeto, mensagem, data, local) VALUES (:projeto, :mensagem, :data, :local);";
            
            
            $cst = $this->con->conectar()->prepare($sql);
            $cst->bindParam(":projeto", $projeto, PDO::PARAM_STR);
            $cst->bindParam(":mensagem", $message, PDO::PARAM_STR);
            $cst->bindParam(":data", $data);
            $cst->bindParam(":local", $_SERVER['HTTP_REFERER'], PDO::PARAM_STR);
            
            if (!$cst->execute()) {
                error_log("ERRO AO INSERIR O LOG SISTEMA ".implode(" ", $cst->errorInfo()));
            }
        } catch (Exception $ex) {
            error_log("ERRO AO INSERIR O LOG SISTEMA ".$ex->getMessage());
        }
    }

}

?>