<?php

class ProjectStage
{

    private static $development = "DEVELOPMENT";

    private static $production = "PRODUCTION";

    public function currentStage()
    {
        return self::$development; 
    }

    public function currentVersion()
    {
        return "1.0";
    }
    
}
?>