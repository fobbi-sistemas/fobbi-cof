<?php
namespace Src\Repository\LandingPage\Oportunidade;

use PDO;
use Src\Repository\GenericRepository;
use Src\Exception\MyException;

class OportunidadeCampoRepository extends GenericRepository
{

    public function findByOportunidade($idOportunidade)
    {
        try {
            $sql = "SELECT oportunidade.valor, campo.nome, campo.tipo FROM oportunidadeCampo oportunidade";
            $sql .= " JOIN campo campo ON campo.id = oportunidade.idCampo";
            $sql .= " WHERE oportunidade.idOportunidade = :idOportunidade;";
            
            $cst = $this->con->conectar()->prepare($sql);
            $cst->bindParam(":idOportunidade", $idOportunidade);
            
            if (! $cst->execute()) {
                throw new MyException(implode(" ", $cst->errorInfo()));
            }
            return $cst->fetchAll(PDO::FETCH_ASSOC);
        } catch (MyException $ex) {
            throw new MyException($ex->getMessage());
        }
    }
    
    public function findBySelecao($id)
    {
        try {
            $cst = $this->con->conectar()->prepare("SELECT nome FROM campoOpcao WHERE id = :id;");
            $cst->bindParam(":id", $id);
            
            if (! $cst->execute()) {
                throw new MyException(implode(" ", $cst->errorInfo()));
            }
            return $cst->fetch()['nome'];
        } catch (MyException $ex) {
            throw new MyException($ex->getMessage());
        }
    }
    
}

?>