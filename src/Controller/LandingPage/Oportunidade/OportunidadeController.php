<?php
namespace Src\Controller\LandingPage\Oportunidade;

use Exception;
use Src\Repository\LandingPage\Oportunidade\OportunidadeRepository;
use Src\Controller\GenericController;

class OportunidadeController extends GenericController
{

    protected $repository;
    
    public function __construct()
    {
        $this->repository = new OportunidadeRepository();
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
    public function save($id, $dados)
    {
        try {
            return $this->repository->save($id, $dados);
        } catch (Exception $ex) {
            throw new Exception($this->getMessagesError(null));
        }
    }
    
}

?>