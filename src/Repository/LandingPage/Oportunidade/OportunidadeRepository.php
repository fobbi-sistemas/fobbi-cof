<?php
namespace Src\Repository\LandingPage\Oportunidade;

use PDO;
use Exception;
use Src\Repository\GenericRepository;
use Src\Exception\MyException;

class OportunidadeRepository extends GenericRepository
{

    public function findAll($filter, $page)
    {
        try {
            $limit = 25;
            $limitStart = ($page - 1) * $limit;
            
            $sql = "SELECT * FROM oportunidade WHERE ativo IS TRUE";
            
            if (! empty($filter['dataCadastroInicial'])) {
                $sql .= " AND data >= :dataCadastroInicial";
            }
            
            if (! empty($filter['dataCadastroFinal'])) {
                $sql .= " AND data <= :dataCadastroFinal";
            }

            if (! empty($filter['status']) && $filter['status'] == "CONSULTANDO") {
                $sql .= " AND (statusFacilCatalogos IS NULL OR statusFacilCatalogos = '')";
            } elseif (! empty($filter['status'])) {
                $sql .= " AND statusFacilCatalogos = :status";
            }
            
            if (! empty($filter['origem']) && $filter['origem'] == "NAO_DEFINIDO") {
                $sql .= " AND (origem IS NULL OR origem = '')";
            } elseif (! empty($filter['origem'])) {
                $sql .= " AND origem = :origem";
            }
            
            $sql .= " ORDER BY data DESC";
            
            if (! empty($page)) {
                $sql .= " LIMIT :limitStart , :limit";
            }
            
            $cst = $this->con->conectar()->prepare($sql);
            
            if (! empty($filter['dataCadastroInicial'])) {
                $cst->bindValue(":dataCadastroInicial", $filter['dataCadastroInicial'] . " 00:00:00", PDO::PARAM_STR);
            }
            
            if (! empty($filter['dataCadastroFinal'])) {
                $cst->bindValue(":dataCadastroFinal", $filter['dataCadastroFinal'] . " 23:59:59", PDO::PARAM_STR);
            }
            
            if (! empty($filter['status']) && $filter['status'] != "CONSULTANDO") {
                $cst->bindValue(":status", $filter['status'], PDO::PARAM_STR);
            }
            
            if (! empty($filter['origem']) && $filter['origem'] != "NAO_DEFINIDO") {
                $cst->bindValue(":origem", $filter['origem'], PDO::PARAM_STR);
            }
            
            if (! empty($page)) {
                $cst->bindValue(":limit", $limit, PDO::PARAM_INT);
                $cst->bindValue(":limitStart", $limitStart, PDO::PARAM_INT);
            }
            
            $cst->execute();
            return $cst->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            throw new MyException($ex->getMessage());
        }
    }

    public function findById($id)
    {
        try {
            $cst = $this->con->conectar()->prepare("SELECT * FROM oportunidade WHERE id = :id;");
            $cst->bindParam(":id", $id);
            $cst->execute();
            return $cst->fetch();
        } catch (Exception $ex) {
            throw new MyException($ex->getMessage());
        }
    }

    // METODOS DE CRUD
    public function save($id, $dados)
    {
        try {
            $sql = "UPDATE oportunidade SET idCnpj = :idCnpj, pessoaResponsavel = :pessoaResponsavel, email = :email,";
            $sql .= " telefone = :telefone, indicacao = :indicacao, observacao = :observacao, loja = :loja,";
            $sql .= " razaoSocial = :razaoSocial, nomeFantasia = :nomeFantasia WHERE id = :id";

            $cst = $this->con->conectar()->prepare($sql);
            $cst->bindParam(":id", $id);
            $cst->bindParam(":idCnpj", $dados['idCnpj']);
            $cst->bindParam(":pessoaResponsavel", $dados['pessoaResponsavel']);
            $cst->bindParam(":email", $dados['email']);
            $cst->bindParam(":telefone", $dados['telefone']);
            $cst->bindParam(":indicacao", $dados['indicacao']);
            $cst->bindParam(":observacao", $dados['observacao']);
            $cst->bindParam(":loja", $dados['loja']);
            $cst->bindParam(":razaoSocial", $dados['razaoSocial']);
            $cst->bindParam(":nomeFantasia", $dados['nomeFantasia']);
            $cst->execute();
        } catch (Exception $ex) {
            throw new MyException($ex->getMessage());
        }
    }
    
    public function delete($id)
    {
        try {
            $cst = $this->con->conectar()->prepare("UPDATE oportunidade SET ativo = false WHERE id = :id;");
            $cst->bindParam(":id", $id);
            $cst->execute();
        } catch (Exception $ex) {
            throw new MyException($ex->getMessage());
        }
    }
}

?>