<?php
namespace Src\Repository\Canais\Dados;

use PDO;
use PDOException;
use Exception;
use Src\Repository\GenericRepository;
use Src\Exception\MyException;

class PersonalizadoRepository extends GenericRepository
{

    public function findAll()
    {
        try {
            $sql = "SELECT * FROM campo WHERE ativo IS TRUE ORDER BY nome;";
            $cst = $this->con->conectar()->prepare($sql);
            
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
            $cst = $this->con->conectar()->prepare("SELECT * FROM formulario WHERE id = :id;");
            $cst->bindParam(":id", $id);
            
            if (! $cst->execute()) {
                throw new PDOException(implode(" ", $cst->errorInfo()));
            }
            return $cst->fetch();
        } catch (Exception $ex) {
            throw new MyException($ex->getMessage());
        }
    }
    
    // METODOS DE CRUD
    public function save($dados)
    {
        $id = null;
        if (empty($dados['id'])) {
            $id = $this->insert($dados);
        } else {
            $id = $this->update($dados);
        }
        return $id;
    }
    
    public function insert($dados)
    {
        try {
            $sql = "INSERT INTO campo (nome, tipo, ativo) VALUES (:nome, :tipo, TRUE);";
            
            $conexao = $this->con->conectar();
            $cst = $conexao->prepare($sql);
            $cst->bindParam(":nome", $dados['nome'], PDO::PARAM_STR);
            $cst->bindParam(":tipo", $dados['tipo'], PDO::PARAM_STR);
            
            if (! $cst->execute()) {
                throw new PDOException(implode(" ", $cst->errorInfo()));
            }
            return $conexao->lastInsertId();
        } catch (Exception $ex) {
            throw new MyException($ex->getMessage());
        }
    }
    
    public function update($dados)
    {
        try {
            $sql = "UPDATE campo SET nome = :nome, tipo = :tipo WHERE id = :id;";
            
            $cst = $this->con->conectar()->prepare($sql);
            $cst->bindParam(":id", $dados['id'], PDO::PARAM_INT);
            $cst->bindParam(":nome", $dados['nome'], PDO::PARAM_STR);
            $cst->bindParam(":tipo", $dados['tipo'], PDO::PARAM_STR);
            
            if (! $cst->execute()) {
                throw new PDOException(implode(" ", $cst->errorInfo()));
            }
            return $dados['id'];
        } catch (Exception $ex) {
            throw new MyException($ex->getMessage());
        }
    }
    
}

?>