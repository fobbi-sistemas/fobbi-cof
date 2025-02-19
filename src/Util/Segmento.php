<?php
namespace Src\Util;

class Segmento
{

    public static function descricao($status)
    {
        if ("VAREJO" === $status) {
            return "Varejo";
        } elseif ("INDUSTRIA" === $status) {
            return "Indústria";
        }  else {
            return "";
        }
    }
    
    public static function list()
    {
        return array("VAREJO", "INDUSTRIA");
    }
    
}
?>