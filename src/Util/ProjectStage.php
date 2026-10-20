<?php

namespace Src\Util;

class ProjectStage
{

    private static $development = "DEVELOPMENT";
    private static $production = "PRODUCTION";

    public function currentStage()
    {
        return self::$production;
    }

    public function currentVersion()
    {
        return "7.9";
    }
    
}
?>