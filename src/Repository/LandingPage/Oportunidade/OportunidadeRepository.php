<?php
namespace Src\Repository\LandingPage\Oportunidade;

use Src\Repository\GenericRepository;
use Src\Exception\MyException;

class OportunidadeRepository extends GenericRepository
{

    public function findAll()
    {
        try {
            $sql = "SELECT id, nome, loja, formulario, idCnpj, data, status, tipo, telefone, email FROM formulario";
            $sql .= " WHERE ativo IS TRUE ORDER BY data DESC;";
            
            $cst = $this->con->conectar()->prepare($sql);
            
            if (! $cst->execute()) {
                throw new MyException(implode(" ", $cst->errorInfo()));
            }
            return $cst->fetchAll();
        } catch (MyException $ex) {
            throw new MyException($ex->getMessage());
        }
    }
    
    public function findById($id)
    {
        try {
            $cst = $this->con->conectar()->prepare("SELECT * FROM formulario WHERE id = :id;");
            $cst->bindParam(":id", $id);
            
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
            $sql = "UPDATE formulario SET status = :status, idCnpj = :idCnpj, pessoaResponsavel = :pessoaResponsavel,";
            $sql .= " email = :email, telefone = :telefone, indicacao = :indicacao, comentario = :comentario,";
            $sql .= " vendedor = :vendedor, motivoSolicitacao = :motivoSolicitacao, nome = :nome, loja = :loja ";
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
            $cst->bindParam(":vendedor", $dados['vendedor']);
            $cst->bindParam(":motivoSolicitacao", $dados['motivoSolicitacao']);
            $cst->bindParam(":nome", $dados['nome']);
            $cst->bindParam(":loja", $dados['loja']);
            
            if (! $cst->execute()) {
                throw new MyException(implode(" ", $cst->errorInfo()));
            }
        } catch (MyException $ex) {
            throw new MyException($ex->getMessage());
        }
    }
    
}

?>