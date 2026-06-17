<?php

namespace Src\Repository;

class GenericRepository {

    protected Conexao $con;

    public function __construct() {
        $this->con = new Conexao();
    }

}

?>