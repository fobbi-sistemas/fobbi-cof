<?php
namespace Src\Controller;

use Exception;
use Src\Repository\CardRepository;
use Src\Model\Card;
use Src\Exception\DefaultException;

class CardController extends GenericController
{

    protected $repository;
    
    public function __construct()
    {
        $this->repository = new CardRepository();
    }
    
    // METODOS DE CONSULTA
    public function findAll($filter, $page)
    {
        try {
            return $this->repository->findAll($filter, $page);
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
    public function save($id, $post, $file)
    {
        try {
            $entity = Card::withPost($id, $post);
            return $this->repository->save($entity, $file);
        } catch (DefaultException $ex) {
            throw new Exception($this->getMessagesError($ex->getMessage()));
        } catch (Exception $ex) {
            throw new Exception($this->getMessagesError(null));
        }
    }
    
}

?>