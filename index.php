<?php

    ini_set('display_errors', true);
    error_reporting(-1);

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
        if ($panda->debug === false) {
            switch ($e->getCode()) {
                case 404:
                    die('Load 404 File');
                    break;
                case 500:
                    die('Load 500 File');
                    break;
                default:
                    die('Load Unknown Error File');
                    break;
            }
            break;
        }
        
        echo '<h3 style="padding:0 5px;">'.$e->getMessage().'</h3>';

        if (($trace = $e->getTrace())) {
            echo '<table width="100%" border="1" cellpadding="5px"><tr><td>File</td><td>Line</td></tr>';

            foreach ($trace as $error) {
                if (isset($error['file'], $error['line'])) {
                    echo '<tr><td>' . $error['file'] . '</td><td>' . $error['line'] . '</td></tr>';
                }
            }

            echo '</table>';
        }
    }