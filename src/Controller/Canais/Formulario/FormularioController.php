<?php
namespace Src\Controller\Canais\Formulario;

use Exception;
use Src\Controller\GenericController;
use Src\Repository\Canais\Formulario\FormularioRepository;

class FormularioController extends GenericController
{

    protected $repository;
    
    public function __construct()
    {
        $this->repository = new FormularioRepository();
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
    
}

?>