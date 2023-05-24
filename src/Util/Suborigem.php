<?php
namespace Src\Util;

class Suborigem
{

    public static function descricao($status)
    {
        if ("LP_COTACAO" === $status) {
            return "LP-COTAÇÃO";
        } elseif ("LP_INDICACAO" === $status) {
            return "LP-Indicação";
        } elseif ("LP-SOLICITACAO" === $status) {
            return "LO-Solicitação";
        } else {
            return "";
        }
    }
    
    public static function list()
    {
        return array("LP_COTACAO", "LP_INDICACAO", "SOLICITACAO");
    }
}
?>