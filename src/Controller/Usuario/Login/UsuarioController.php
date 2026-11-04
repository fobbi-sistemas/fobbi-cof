<?php

namespace Src\Controller\Usuario\Login;

use Src\Exception\MyException;
use Src\Repository\Usuario\Login\UsuarioRepository;
use Src\Util\Csrf;

class UsuarioController
{

    public function login($dados)
    {
        try {
            $objRepositoryUsuario = new UsuarioRepository();
            $valido = $objRepositoryUsuario->login($dados);

            if ($valido) {
                // Novo id e novo token a cada login: impede session fixation.
                session_regenerate_id(true);
                Csrf::regenerate();
            }
            return $valido;
        } catch (MyException $ex) {
            throw new MyException($ex->getMessage());
        }
    }

}

?>