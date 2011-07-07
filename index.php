<?php

    require_once 'Core/Config.php';

    try {

        spl_autoload_register(function($name){
            $class = str_replace('\\', '/', $name);

            if (is_readable($filename)) {
                require_once $filename;
            }
            
            throw new Core\Exceptions\AutoloaderException('Panda Autoloader could not find ' . $name . ' Class. Check the Spelling of the Class and the Filename');
        }, true, true);
    
    } catch (Exception $e) {
        //temp
        die($e->getMessage());
    }
