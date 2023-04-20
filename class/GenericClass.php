<?php

require_once "MyException.php";
require_once "DefaultException.php";
require_once "Conexao.php";
require_once "ProjectStage.php";

class GenericClass {
    
    public function __construct() {
        $this->con = new Conexao();
    }
    
}

?>