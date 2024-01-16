<?php

class Autoload
{
    public static function inclusionAuto($className): void
    {
        $basePath = __DIR__;
        $classFile = $basePath . '/' . str_replace("\\", "/", $className) . ".php";

        if (file_exists($classFile)) {
            require $classFile;
        }
    }
}

spl_autoload_register(['Autoload', 'inclusionAuto']);