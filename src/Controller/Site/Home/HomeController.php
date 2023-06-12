<?php
namespace Src\Controller\Site\Home;

use Exception;
use Src\Controller\GenericController;
use Src\Repository\Site\Home\HomeRepository;
use Src\Exception\DefaultException;

class HomeController extends GenericController
{

    protected $repository;

    public function __construct()
    {
        $this->repository = new HomeRepository();
    }

    // METODOS DE CONSULTA
    public function findById()
    {
        try {
            return $this->repository->findById();
        } catch (Exception $ex) {
            throw new Exception($this->getMessagesError(null));
        }
    }
    
    public function save($dados, $files)
    {
        try {
            return $this->repository->save($dados, $files);
        } catch (DefaultException $ex) {
            throw new Exception($this->getMessagesError($ex->getMessage()));
        } catch (Exception $ex) {
            throw new Exception($this->getMessagesError(null));
        }
    }

}

?>