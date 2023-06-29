<?php
namespace Src\Repository\Canais\Formulario;

use PDO;
use Src\Repository\GenericRepository;
use Src\Exception\MyException;

class FormularioRepository extends GenericRepository
{

    public function findAll()
    {
        try {
            $sql = "SELECT * FROM formulario ORDER BY nome;";
            $cst = $this->con->conectar()->prepare($sql);

            if (! $cst->execute()) {
                throw new MyException(implode(" ", $cst->errorInfo()));
            }
            return $cst->fetchAll(PDO::FETCH_ASSOC);
        } catch (MyException $ex) {
            throw new MyException($ex->getMessage());
        }
    }
}

?>