<?php
namespace Src\Repository\CampoDados\Dados;

use PDO;
use PDOException;
use Exception;
use Src\Repository\GenericRepository;
use Src\Exception\MyException;

class CampoOpcaoRepository extends GenericRepository
{

    public function findByIdCampo($idCampo)
    {
        try {
            $sql = "SELECT * FROM campoOpcao WHERE ativo IS TRUE AND idCampo = :idCampo ORDER BY ordem;";
            $cst = $this->con->conectar()->prepare($sql);
            $cst->bindParam(":idCampo", $idCampo);
            
            if (! $cst->execute()) {
                throw new PDOException(implode(" ", $cst->errorInfo()));
            }
            return $cst->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            throw new MyException($ex->getMessage());
        }
    }
    
    public function findById($id)
    {
        try {
            $cst = $this->con->conectar()->prepare("SELECT * FROM campoOpcao WHERE id = :id;");
            $cst->bindParam(":id", $id);
            
            if (! $cst->execute()) {
                throw new PDOException(implode(" ", $cst->errorInfo()));
            }
            return $cst->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            throw new MyException($ex->getMessage());
        }
    }
    
    // METODOS DE CRUD
    public function save($dados)
    {
        $id = null;
        if (empty($dados['idCampoOpcao'])) {
            $id = $this->insert($dados);
        } else {
            $id = $this->update($dados);
        }
        return $id;
    }
    
    public function delete($id)
    {
        try {
            $sql = "UPDATE campoOpcao SET ativo = FALSE WHERE id = :id;";
            
            $cst = $this->con->conectar()->prepare($sql);
            $cst->bindParam(":id", $id, PDO::PARAM_INT);
            
            if (! $cst->execute()) {
                throw new PDOException(implode(" ", $cst->errorInfo()));
            }
        } catch (Exception $ex) {
            throw new MyException($ex->getMessage());
        }
    }
    
    private function insert($dados)
    {
        try {
            $sql = "INSERT INTO campoOpcao (nome, ordem, ativo, idCampo) VALUES (:nome, :ordem, TRUE, :idCampo);";
            
            $conexao = $this->con->conectar();
            $cst = $conexao->prepare($sql);
            $cst->bindParam(":nome", $dados['nomeCampoOpcao'], PDO::PARAM_STR);
            $cst->bindParam(":ordem", $dados['ordemCampoOpcao'], PDO::PARAM_STR);
            $cst->bindParam(":idCampo", $dados['idCampo'], PDO::PARAM_INT);
            
            if (! $cst->execute()) {
                throw new PDOException(implode(" ", $cst->errorInfo()));
            }
            return $conexao->lastInsertId();
        } catch (Exception $ex) {
            throw new MyException($ex->getMessage());
        }
    }
    
    private function update($dados)
    {
        try {
            $sql = "UPDATE campoOpcao SET nome = :nome, ordem = :ordem WHERE id = :id;";
            
            $cst = $this->con->conectar()->prepare($sql);
            $cst->bindParam(":id", $dados['idCampoOpcao'], PDO::PARAM_INT);
            $cst->bindParam(":nome", $dados['nomeCampoOpcao'], PDO::PARAM_STR);
            $cst->bindParam(":ordem", $dados['ordemCampoOpcao'], PDO::PARAM_STR);
            
            if (! $cst->execute()) {
                throw new PDOException(implode(" ", $cst->errorInfo()));
            }
            return $dados['idCampoOpcao'];
        } catch (Exception $ex) {
            throw new MyException($ex->getMessage());
        }
    }
    
}

?>