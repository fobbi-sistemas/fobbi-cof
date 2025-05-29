<?php
namespace Src\Util;

class StatusOportunidade
{

    public static function descricao($status)
    {
        if ("ATIVO" === $status) {
            return "Ativo";
        } elseif ("CADASTRADO" === $status) {
            return "Cadastrado";
        } elseif ("LEAD" === $status) {
            return "Lead";
        } elseif ("CONSULTANDO" === $status) {
            return "Consultando";
        }  elseif ("ATENDIMENTO" === $status) {
            return "Atendimento";
        }
        return "";
    }
    
    public static function cor($status)
    {
        
        if ("LEAD" === $status) {
            return "bg-secondary";
        } elseif ("CADASTRADO" === $status) {
            return "bg-warning";
        } elseif ("ATIVO" === $status) {
            return "bg-success";
        } elseif ("ATENDIMENTO" === $status) {
            return "bg-primary";
        }else {
            return "text-dark";
        }
        
    }
    
    public static function list()
    {
        return array("LEAD", "ATENDIMENTO", "CADASTRADO", "ATIVO");
    }
}
?>