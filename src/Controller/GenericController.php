<?php
namespace Src\Controller;

class GenericController
{

    public function getMessagesError($message)
    {
        if (empty($message)) {
            return '<div class="alert alert-warning text-center alert-dismissible fade show" role="alert"><i class="bi bi-exclamation-triangle-fill me-1"></i>Ops! Ocorreu um erro, entre em contato com o suporte.</div>';
        } else {
            return '<div class="alert alert-warning text-center alert-dismissible fade show" role="alert"><i class="bi bi-exclamation-triangle-fill me-1"></i>' . $message . '</div>';
        }
    }
}

?>