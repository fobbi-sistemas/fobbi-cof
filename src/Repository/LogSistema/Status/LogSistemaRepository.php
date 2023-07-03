<?php
namespace Src\Repository\LogSistema\Status;

use PDOException;
use Exception;
use Src\Repository\GenericRepository;

class LogSistemaRepository extends GenericRepository
{

    // METODOS DE CONSULTA
    public function findAll()
    {
        try {
            $sql = "SELECT COUNT(id) AS qtde FROM logsistema WHERE resolvido IS FALSE;";
            $cst = $this->con->conectar()->prepare($sql);

            if (! $cst->execute()) {
                throw new PDOException(implode(" ", $cst->errorInfo()));
            }
            return $cst->fetch()['qtde'];
        } catch (Exception $ex) {
            error_log("ERRO AO INSERIR O LOG SISTEMA " . implode(" ", $cst->errorInfo()));
        }
    }
}

?>