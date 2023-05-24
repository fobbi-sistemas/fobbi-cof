<?php

namespace Src\Repository;

class GenericRepository {
    
    public function __construct() {
        $this->con = new Conexao();
    }
    
}

?>