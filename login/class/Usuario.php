<?php
include_once "../class/GenericClass.php";

class Usuario extends GenericClass
{

    public function login($dados)
    {
        try {
            if ($dados['login'] != null && ! empty($dados['login']) && $dados['senha'] != null && ! empty($dados['senha'])) {

                $cst = $this->con->conectar()->prepare("SELECT id, login, senha FROM usuario WHERE ativo IS TRUE");
                
                if (! $cst->execute()) {
                    throw new MyException(implode(" ", $cst->errorInfo()));
                }
                
                $result = $cst->fetchAll();

                foreach ($result as $usuario) {
                    if (strtolower($usuario['login']) == strtolower($dados['login']) && password_verify($dados['senha'], $usuario['senha'])) {
                        
                        $_SESSION['idUsuarioFobbiSiteAdmin'] = $usuario['id'];
                        $this->updateUltimoAcesso($usuario['id']);
                        return true;
                    }
                }
            }
            return false;
        } catch (MyException $ex) {
            throw new MyException($ex->getMessage());
        }
    }

    private function updateUltimoAcesso($id)
    {
        try {
            $conexao = $this->con->conectar();
            $cst = $conexao->prepare("UPDATE usuario SET dataUltimoAcesso = :dataUltimoAcesso WHERE id = :id;");
            $cst->bindValue(":id", $id);
            $cst->bindValue(":dataUltimoAcesso", date('Y-m-d H:i:s'));

            if (! $cst->execute()) {
                throw new MyException(implode(" ", $cst->errorInfo()));
            }
        } catch (MyException $ex) {
            throw new MyException($ex->getMessage());
        }
    }
}

?>