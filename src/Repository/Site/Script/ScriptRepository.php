<?php
namespace Src\Repository\Site\Script;

use Src\Repository\GenericRepository;
use Src\Exception\MyException;

class ScriptRepository extends GenericRepository
{
    
    // METODOS DE CONSULTA
    public function findAll()
    {
        try {
            $cst = $this->con->conectar()->prepare("SELECT * FROM script ORDER BY id");
            
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
            $cst = $this->con->conectar()->prepare("SELECT * FROM script WHERE id = :id");
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
            $sql = "UPDATE script SET script = :script WHERE id = :id";

            $cst = $this->con->conectar()->prepare($sql);
            $cst->bindParam(":script", $dados['script']);
            $cst->bindParam(":id", $id);

            if (! $cst->execute()) {
                throw new MyException(implode(" ", $cst->errorInfo()));
            }
        } catch (MyException $ex) {
            throw new MyException($ex->getMessage());
        }
    }
}

?>