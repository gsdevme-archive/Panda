<?php
    $root = realpath(dirname(__FILE__)) . '/../';
    require_once $root . 'Core/Config.php';
    require_once $root . 'Core/Exceptions/ExceptionAbstract.php';
    require_once $root . 'Core/Exceptions/AutoloaderException.php';
    require_once $root . 'Core/Functions.php';
    require_once $root . 'Core/RegistryAbstract.php';
    require_once $root . 'Core/Panda.php';
    require_once $root . 'Core/Registry.php';

    $panda = Core\Panda::getInstance()->import($config);
    $panda->root = $root;
    
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

		}, true, true);
