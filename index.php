<?php

    require_once 'Core/config.php';

    spl_autoload_register(function($name)
    {
        $class = str_replace('\\', '/', $name);

        if (is_readable($filename)) {
            
        }
    });

    