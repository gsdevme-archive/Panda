<?php

    require_once 'Core/Config.php';
    require_once 'Core/Functions.php';
    $sys = realpath(dirname(__FILE__)) . '/';

    try {
        spl_autoload_register(function($class) use ($sys) {
                $filename = $sys . str_replace('\\', '/', $class) . '.php';

                if (is_readable($filename)) {
                    require_once $filename;
                    return;
                }

                throw new \Core\Exceptions\AutoloaderException('Panda Autoloader could not find ' . $class . ' Class. Check the Spelling of the Class and the Filename');
            }, true, true);

        $panda = Core\Panda::getInstance()->import($config);
        $panda->sys = $sys;

        Core\Router::route(new \Core\Request());
    } catch (Exception $e) {
        //temp
        die($e->getMessage());
    }

    echo (memory_get_usage() - Core\Panda::getInstance()->memory) / 1024 . ' kb';