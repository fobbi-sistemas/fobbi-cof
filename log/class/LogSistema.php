<?php

include_once "../class/Conexao.php";

class LogSistema {
    
    public function __construct() {
        $this->con = new Conexao();
    }

    // METODOS DE CONSULTA
    public function findAll(){
        try{
            $cst = $this->con->conectar()->prepare("SELECT COUNT(id) AS qtde FROM logsistema WHERE resolvido IS FALSE;");
            if (!$cst->execute()) {
                error_log("ERRO AO INSERIR O LOG SISTEMA ".implode(" ", $cst->errorInfo()));
            }
            return $cst->fetch()['qtde'];
        } catch (Exception $ex) {
            error_log("ERRO AO INSERIR O LOG SISTEMA ".implode(" ", $cst->errorInfo()));
        }
    }
    
}

?>