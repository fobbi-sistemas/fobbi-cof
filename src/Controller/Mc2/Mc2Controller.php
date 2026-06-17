<?php

namespace Src\Controller\Mc2;

use Src\Controller\GenericController;
use Src\Repository\Mc2\Mc2Repository;
use Exception;

class Mc2Controller extends GenericController
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new Mc2Repository();
    }

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

    public function save($id, $dados)
    {
        try {
            $this->repository->save($id, $dados);
        } catch (Exception $ex) {
            throw new Exception($this->getMessagesError(null));
        }
    }
}
