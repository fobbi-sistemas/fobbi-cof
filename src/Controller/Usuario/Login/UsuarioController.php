<?php

namespace Src\Controller\Usuario\Login;

use Src\Exception\MyException;
use Src\Repository\Usuario\Login\UsuarioRepository;

class UsuarioController
{

    public function login($dados)
    {
        try {
            $objRepositoryUsuario = new UsuarioRepository();
            return $objRepositoryUsuario->login($dados);
        } catch (MyException $ex) {
            throw new MyException($ex->getMessage());
        }
    }

}

?>