<?php
namespace Src\Controller\LandingPage\Oportunidade;

use Exception;
use Src\Repository\LandingPage\Oportunidade\OportunidadeRepository;
use Src\Controller\GenericController;
use Src\Repository\LandingPage\Oportunidade\OportunidadeCampoRepository;

class OportunidadeController extends GenericController
{

    protected $repository;
    protected $campoRepository;
    
    public function __construct()
    {
        $this->repository = new OportunidadeRepository();
        $this->campoRepository = new OportunidadeCampoRepository();
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
    
    public function findByStatus($id)
    {
        try {
            return $this->repository->findByStatus($id);
        } catch (Exception $ex) {
            throw new Exception($this->getMessagesError(null));
        }
    }
    
    public function findByCampo($id)
    {
        try {
            return $this->campoRepository->findByOportunidade($id);
        } catch (Exception $ex) {
            throw new Exception($this->getMessagesError(null));
        }
    }
    
    public function findValor($campo)
    {
        try {
            if ($campo['tipo'] == "SELECAO") {
                return $this->campoRepository->findBySelecao($campo['valor']);
            }
            return null;
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
    
    public function delete($id)
    {
        try {
            return $this->repository->delete($id);
        } catch (Exception $ex) {
            throw new Exception($this->getMessagesError(null));
        }
    }
    
    public function validarHistoricoAtendimento($id)
    {
        try {
            return $this->repository->validarHistoricoAtendimento($id);
        } catch (Exception $ex) {
            throw new Exception($this->getMessagesError(null));
        }
    }
    
}

?>