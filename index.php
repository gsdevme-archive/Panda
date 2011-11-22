<?php

    $root = realpath(dirname(__FILE__)) . '/';
    require_once $root . 'functions.php';
    require_once $root . 'Core/Config.php';
    require_once $root . 'Core/Exceptions/ExceptionAbstract.php';
    require_once $root . 'Core/Exceptions/AutoloaderException.php';
    require_once $root . 'Core/Functions.php';
    require_once $root . 'Core/RegistryAbstract.php';
    require_once $root . 'Core/Panda.php';

    $panda = Core\Panda::getInstance()->import($config);
    $panda->root = $root;
    $panda->thirdParty = $root . 'Core/ThirdParty/';

    $panda->memoryUsage = memory_get_usage() / 1024;
    $panda->microtime = microtime(true);

    //Remove to help with memory
    unset($config);
    unset($root);

    set_error_handler(function($errno, $errstr, $errfile, $errline ) {
            throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
        });

    try {
        spl_autoload_register(function($class) use ($panda) {
                $file = str_replace('\\', '/', $class) . '.php';

                $rootFile = $panda->root . $file;
                $appRootFile = $panda->appRoot . $file;

                if (is_readable($rootFile)) {
                    require_once $rootFile;
                    return;
                }

                if (is_readable($appRootFile)) {
                    require_once $appRootFile;
                    return;
                }

                throw new \Core\Exceptions\AutoloaderException('Panda Autoloader could not find ' . $class . ' Class. Check the Spelling of the Class and the Filename');
            }, true, true);

        new Core\Router(new \Core\Request());
    } catch (Exception $e) {
        if (ob_get_status() != false) {
            // Remove anything from the buffer
            if (ob_get_length() > 0) {
                ob_end_clean();
            }
        }

        $errorReport = new \Core\ErrorReport($e);
        echo $errorReport->getOutput();
        exit;
    }