<?php

namespace Src\Util;

class ProjectStage
{

    public static function currentStage()
    {
        return AppConfig::get('app_stage', "DEVELOPMENT");
    }

    public static function currentStageProduction()
    {
        return self::currentStage() == "PRODUCTION";
    }

    public function currentVersion()
    {
        return "8.0";
    }
    
}
?>
