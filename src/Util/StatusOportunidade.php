<?php
namespace Src\Util;

class StatusOportunidade
{

    public static function descricao($status)
    {
        if ("PENDENTE" === $status) {
            return "Pendente";
        } elseif ("CADASTRADO" === $status) {
            return "Cadastrado";
        } elseif ("ATIVO" === $status) {
            return "Ativo";
        } else {
            return "Pendente";
        }
    }
    
    public static function cor($status)
    {
        
        if ("PENDENTE" === $status) {
            return "bg-secondary";
        } elseif ("CADASTRADO" === $status) {
            return "bg-warning";
        } elseif ("ATIVO" === $status) {
            return "bg-success";
        } else {
            return "bg-secondary";
        }
        
    }
    
    public static function list()
    {
        return array("PENDENTE", "CADASTRADO", "ATIVO");
    }
}
?>