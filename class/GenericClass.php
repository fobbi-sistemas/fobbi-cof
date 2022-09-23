<?php

require_once "MyException.php";
require_once "DefaultException.php";
require_once "Conexao.php";
require_once "ProjectStage.php";

class GenericClass {
    
    public function __construct() {
        $this->con = new Conexao();
    }
    
    public function url()
    {
        try {
            $conexao = $this->con->conectar();
            $cst = $conexao->prepare("SELECT url FROM loja WHERE id = :id;");
            $cst->bindValue(":id", $_SESSION['idLojaAdmin']);
            if (! $cst->execute()) {
                throw new MyException(implode(" ", $cst->errorInfo()));
            }
            return $cst->fetch()['url'];
        } catch (MyException $ex) {
            throw new MyException($ex->getMessage());
        }
    }
    
}

?>