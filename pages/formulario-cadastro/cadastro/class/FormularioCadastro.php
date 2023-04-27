<?php
include_once "../../../class/GenericClass.php";

class FormularioCadastro extends GenericClass
{

    // METODOS DE CONSULTA
    public function findById($id)
    {
        try {
            $cst = $this->con->conectar()->prepare("SELECT * FROM formulario WHERE id = :id;");
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
            if ($dados['tipo'] == "INDICACAO") {
                $this->saveIndicar($id, $dados);
            } else {
                $this->saveSolicitar($id, $dados);
            }
        } catch (MyException $ex) {
            throw new MyException($ex->getMessage());
        }
    }
    
    public function saveIndicar($id, $dados)
    {
        try {
            $sql = "UPDATE formulario SET status = :status, idCnpj = :idCnpj, pessoaResponsavel = :pessoaResponsavel,";
            $sql .= " email = :email, telefone = :telefone, indicacao = :indicacao, comentario = :comentario";
            $sql .= " WHERE id = :id";
            
            $cst = $this->con->conectar()->prepare($sql);
            $cst->bindParam(":id", $id);
            $cst->bindParam(":status", $dados['status']);
            $cst->bindParam(":idCnpj", $dados['idCnpj']);
            $cst->bindParam(":pessoaResponsavel", $dados['pessoaResponsavel']);
            $cst->bindParam(":email", $dados['email']);
            $cst->bindParam(":telefone", $dados['telefone']);
            $cst->bindParam(":indicacao", $dados['indicacao']);
            $cst->bindParam(":comentario", $dados['comentario']);
            
            if (! $cst->execute()) {
                throw new MyException(implode(" ", $cst->errorInfo()));
            }
        } catch (MyException $ex) {
            throw new MyException($ex->getMessage());
        }
    }
    
    public function saveSolicitar($id, $dados)
    {
        try {
            $sql = "UPDATE formulario SET status = :status, idCnpj = :idCnpj, vendedor = :vendedor,";
            $sql .= " motivoSolicitacao = :motivoSolicitacao WHERE id = :id";
            
            $cst = $this->con->conectar()->prepare($sql);
            $cst->bindParam(":id", $id);
            $cst->bindParam(":status", $dados['status']);
            $cst->bindParam(":idCnpj", $dados['idCnpj']);
            $cst->bindParam(":vendedor", $dados['vendedor']);
            $cst->bindParam(":motivoSolicitacao", $dados['motivoSolicitacao']);
            
            if (! $cst->execute()) {
                throw new MyException(implode(" ", $cst->errorInfo()));
            }
        } catch (MyException $ex) {
            throw new MyException($ex->getMessage());
        }
    }

}

?>