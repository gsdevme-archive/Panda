<?php

    namespace Core;
    use \Core\Exceptions\LoadException as Exception;
    /**
     * Static factory
     */
    class Factory
    {

        private static $_registry;
        private static $_panda;

        public static function model($name, $shared = false)
        {
            return self::_loader($name, 'models', $shared,'Model not found -> '.$name);
        }

        /**
         * Load a library
         * @param string $name name of the library
         * @param bool $shared is this a shared library?
         * @return object
         */
        public static function library($name, $shared = false)
        {
            return self::_loader($name, 'libraries', $shared,'Library not found -> '.$name);
        }

        public static function serviceLayer($name, $shared = false)
        {
            return self::_loader($name, 'serviceLayers', $shared,'Service layer not found -> '.$name);
        }

        public static function view($name, array $args = null, $shared = false)
        {
            $view = new View;
            $view->load($name,$args,$shared);
            return $view;
        }

        private static function _loader($name, $type, $shared = false, $exception = 'Factory error')
        {
            self::_init();
            $name = ucfirst($name);
            
            //type is going to be something like model or library
            $regMethod = $type;
            $dir = ucfirst($type);

            if (self::$_registry->$regMethod($name)) {
                return self::$_registry->$regMethod($name);
            } else {
                $file = ($shared === false) ? self::$_panda->appRoot . $dir . '/' : self::$_panda->root . 'Shared/' . $dir . '/';
                $file.=$name . '.php';

                if (is_readable($file)) {
                    require_once $file;

                    $class = $dir . '\\' . ucfirst($name);

                    $name .= ( $shared == true) ? '__shared' : '';

                    return self::$_registry->$regMethod($name, new $class);
                }
            }
            throw new Exception($exception);
        }

        private static function _init()
        {
            if (!self::$_panda instanceof RegistryAbstract) {
                self::$_registry = Registry::getInstance();
                self::$_panda = Panda::getInstance();
            }
        }

    }