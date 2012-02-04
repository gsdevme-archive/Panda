<?php

    /**
    * Twitter: @gsphpdev
    */

    $root = realpath(dirname(__FILE__)) . '/';
    require_once $root . 'functions.php';
    require_once $root . 'System/Config.php';
    require_once $root . 'System/Panda/Exceptions/ExceptionAbstract.php';
    require_once $root . 'System/Panda/Exceptions/AutoloaderException.php';
    require_once $root . 'System/Panda/Functions.php';
    require_once $root . 'System/Panda/RegistryAbstract.php';
    require_once $root . 'System/Panda/Panda.php';

    $panda = System\Panda\Panda::getInstance()->import($config);
    $panda->root = $root;
    $panda->thirdParty = $root . 'System/Panda/ThirdParty/';

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

                throw new \System\Panda\Exceptions\AutoloaderException('Panda Autoloader could not find ' . $class . ' Class. Check the Spelling of the Class and the Filename');
            }, true, true);

        new \System\Panda\Router(new \System\Panda\Request());
    } catch (Exception $e) {
        if (ob_get_status() != false) {
            // Remove anything from the buffer
            if (ob_get_length() > 0) {
                ob_end_clean();
            }
        }

        $errorReport = new \System\Panda\ErrorReport($e);
        echo $errorReport->getOutput();
        exit;
    }