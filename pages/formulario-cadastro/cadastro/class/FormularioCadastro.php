<?php
include_once "../../../class/GenericClass.php";

class FormularioCadastro extends GenericClass
{

    // METODOS DE CONSULTA
    public function findById($id)
    {
        try {
            $cst = $this->con->conectar()->prepare("SELECT * FROM formulario WHERE id = 1;");
            $cst->bindParam(":id", $id, PDO::PARAM_INT);
            
            if (! $cst->execute()) {
                throw new MyException(implode(" ", $cst->errorInfo()));
            }
            return $cst->fetch();
        } catch (MyException $ex) {
            throw new MyException($ex->getMessage());
        }
    }

    // METODOS DE CRUD
    public function save($id, $dados)
    {
        try {
            $sql = "UPDATE formulario SET status = :status, cnpj = :cnpj, canal = :canal, contatoNome = :contatoNome,";
            $sql .= " email = :email, telefone = :telefone WHERE id = :id";
            
            $cst = $this->con->conectar()->prepare($sql);
            $cst->bindParam(":id", $id);
            $cst->bindParam(":status", $dados['status']);
            $cst->bindParam(":cnpj", $dados['cnpj']);
            $cst->bindParam(":canal", $dados['canal']);
            $cst->bindParam(":contatoNome", $dados['contatoNome']);
            $cst->bindParam(":email", $dados['email']);
            $cst->bindParam(":telefone", $dados['telefone']);
            
            if (! $cst->execute()) {
                throw new MyException(implode(" ", $cst->errorInfo()));
            }
        } catch (MyException $ex) {
            throw new MyException($ex->getMessage());
        }
    }

}

?>