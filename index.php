<?php

    $sys = realpath(dirname(__FILE__)) . '/';
    require_once $sys . 'Core/Config.php';
    require_once $sys . 'Core/Exceptions/ExceptionAbstract.php';
    require_once $sys . 'Core/Exceptions/AutoloaderException.php';
    require_once $sys . 'Core/Functions.php';
    require_once $sys . 'Core/RegistryAbstract.php';
    require_once $sys . 'Core/Panda.php';
    require_once $sys . 'Core/Registry.php';

    $panda = Core\Panda::getInstance()->import($config);
    $panda->sys = $sys;

    try {
        spl_autoload_register(function($class) use ($panda) {
                $file = str_replace('\\', '/', $class) . '.php';

                $sysFile = $panda->sys . $file;
                $appFile = $panda->sysApp . $file;

                if (is_readable($sysFile)) {
                    require_once $sysFile;
                    return;
                }

                if (is_readable($appFile)) {
                    require_once $appFile;
                    return;
                }

                throw new \Core\Exceptions\AutoloaderException('Panda Autoloader could not find ' . $class . ' Class. Check the Spelling of the Class and the Filename');
            }, true, true);
        Core\Router::route(new \Core\Request());
    } catch (Exception $e) {
        //temp
        die($e->getMessage());
    }