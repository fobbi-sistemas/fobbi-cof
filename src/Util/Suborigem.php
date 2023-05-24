<?php
namespace Src\Util;

class Suborigem
{

    public static function descricao($status)
    {
        if ("LP_COTACAO" === $status) {
            return "LP-COTAÇÃO";
        } elseif ("LP_INDICACAO" === $status) {
            return "LP-INDICAÇÃO";
        } elseif ("LP_SOLICITACAO" === $status) {
            return "LP-SOLICITAÇÃO";
        } else {
            return "";
        }
    }
    
    public static function list()
    {
        return array("LP_COTACAO", "LP_INDICACAO", "LP_SOLICITACAO");
    }
}
?>