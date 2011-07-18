<?php

    ini_set('display_errors', true);
    error_reporting(-1);
    define('SYS_MEMORY_USE', memory_get_usage());
    define('SYS_TIME_AT_RUNTIME', microtime(true));

    $root = realpath(dirname(__FILE__)) . '/';
    require_once $root . 'Core/Config.php';
    require_once $root . 'Core/Exceptions/ExceptionAbstract.php';
    require_once $root . 'Core/Exceptions/AutoloaderException.php';
    require_once $root . 'Core/Functions.php';
    require_once $root . 'Core/RegistryAbstract.php';
    require_once $root . 'Core/Panda.php';
    require_once $root . 'Core/Registry.php';

    $panda = Core\Panda::getInstance()->import($config);
    $panda->root = $root;

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
        $errorReport = new \Core\ErrorReport($e);
        die($errorReport->getOutput());
    }

    echo '<h2>Memory: ' . round(((memory_get_usage() - SYS_MEMORY_USE) / 1024),3) . 'Kb</h2>';
    echo '<h2>Time: ' . round(((microtime(true) - SYS_TIME_AT_RUNTIME)*1000),5) . ' ms</h2><br/>';