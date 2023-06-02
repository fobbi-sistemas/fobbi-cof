<?php
namespace Src\Controller\Site\Script;

use Exception;
use Src\Controller\GenericController;
use Src\Repository\Site\Script\ScriptRepository;

class ScriptController extends GenericController
{

    protected $repository;

    public function __construct()
    {
        $this->repository = new ScriptRepository();
    }

    // METODOS DE CONSULTA
    public function findAll()
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