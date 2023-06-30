<?php
namespace Src\Repository\LandingPage\Oportunidade;

use PDO;
use Src\Repository\GenericRepository;
use Src\Exception\MyException;

class OportunidadeRepository extends GenericRepository
{

    public function findAll()
    {
        try {
            $sql = "SELECT * FROM oportunidade WHERE ativo IS TRUE ORDER BY data DESC;";
            
            $cst = $this->con->conectar()->prepare($sql);
            
            if (! $cst->execute()) {
                throw new MyException(implode(" ", $cst->errorInfo()));
            }
            return $cst->fetchAll(PDO::FETCH_ASSOC);
        } catch (MyException $ex) {
            throw new MyException($ex->getMessage());
        }
    }
    
    public function findById($id)
    {
        try {
            $cst = $this->con->conectar()->prepare("SELECT * FROM oportunidade WHERE id = :id;");
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
            $sql = "UPDATE oportunidade SET status = :status, idCnpj = :idCnpj, pessoaResponsavel =";
            $sql .= " :pessoaResponsavel, email = :email, telefone = :telefone, indicacao = :indicacao, comentario =";
            $sql .= " :comentario, motivoSolicitacao = :motivoSolicitacao, loja = :loja, razaoSocial = :razaoSocial,";
            $sql .= " nomeFantasia = :nomeFantasia WHERE id = :id";
            
            $cst = $this->con->conectar()->prepare($sql);
            $cst->bindParam(":id", $id);
            $cst->bindParam(":status", $dados['status']);
            $cst->bindParam(":idCnpj", $dados['idCnpj']);
            $cst->bindParam(":pessoaResponsavel", $dados['pessoaResponsavel']);
            $cst->bindParam(":email", $dados['email']);
            $cst->bindParam(":telefone", $dados['telefone']);
            $cst->bindParam(":indicacao", $dados['indicacao']);
            $cst->bindParam(":comentario", $dados['comentario']);
            $cst->bindParam(":motivoSolicitacao", $dados['motivoSolicitacao']);
            $cst->bindParam(":loja", $dados['loja']);
            $cst->bindParam(":razaoSocial", $dados['razaoSocial']);
            $cst->bindParam(":nomeFantasia", $dados['nomeFantasia']);
            
            if (! $cst->execute()) {
                throw new MyException(implode(" ", $cst->errorInfo()));
            }
        } catch (MyException $ex) {
            throw new MyException($ex->getMessage());
        }
    }
    
}

?>