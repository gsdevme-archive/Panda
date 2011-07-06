<?php

    require_once 'Core/config.php';

    function pandaAutoload($name)
    {
        $class = str_replace('\\', '/', $name);

        if (is_readable($filename)) {
            
        }
    }

    spl_autoload_register('PandaAutoload');

    