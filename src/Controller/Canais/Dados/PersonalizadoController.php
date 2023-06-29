<?php
namespace Src\Controller\Canais\Dados;

use Exception;
use Src\Controller\GenericController;
use Src\Repository\Canais\Dados\PersonalizadoRepository;

class PersonalizadoController extends GenericController
{

    protected $repository;
    
    public function __construct()
    {
        $this->repository = new PersonalizadoRepository();
    }
    
    // METODOS DE CONSULTA
    public function findByAll()
    {
        try {
            return $this->repository->findAll();
        } catch (Exception $ex) {
            throw new Exception($this->getMessagesError(null));
        }
    }

    public function findById($id)
    {
        try {
            return $this->repository->findById($id);
        } catch (Exception $ex) {
            throw new Exception($this->getMessagesError(null));
        }
    }
    
    // METODOS DE CRUD
    public function save($dados)
    {
        try {
            return $this->repository->save($dados);
        } catch (Exception $ex) {
            throw new Exception($this->getMessagesError(null));
        }
    }
    
}

?>