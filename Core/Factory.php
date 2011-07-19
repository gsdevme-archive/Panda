<?php

    namespace Core;

use \Core\Exceptions\FactoryException as FactoryException;

    /**
     * Static factory
     */
    class Factory
    {

        private static $_registry;
        private static $_panda;

        /**
         * load a model
         * @param type $name
         * @param type $shared
         * @return Model 
         */
        public static function model($name, $shared = false)
        {
            $model = self::_loader(ucfirst($name), 'models', $shared);

            // Check if its parent is a Model
            if ($model instanceof Model) {
                return $model;
            }

            throw new Exception($name . ' is not an instance of \Core\Model');
        }

        /**
         * Load a library
         * @param string $name name of the library
         * @param bool $shared is this a shared library?
         * @return object
         */
        public static function library($name, $shared = false)
        {
            return self::_loader(ucfirst($name), 'libraries', $shared);
        }

        /**
         * load a service layer
         * @param type $name
         * @param type $shared
         * @return ServiceLayer 
         */
        public static function serviceLayer($name, $shared = false)
        {
            $sl = self::_loader(ucfirst($name), 'serviceLayers', $shared);

            // Check if its parent is a ServiceLayer
            if ($sl instanceof ServiceLayer) {
                return $sl;
            }

            throw new Exception($name . ' is not an instance of \Core\ServiceLayer');
        }

        /**
         * load a helper
         * @param type $name
         * @param type $shared
         * @return type 
         */
        public static function helper($name, $shared = false)
        {
            return self::_loader(ucfirst($name), 'helpers', $shared);
        }

        /**
         *
         * @param string $name
         * @param type $namespace
         * @param type $shared
         * @param type $exception
         * @return type 
         */
        private static function _loader($name, $namespace, $shared = false)
        {
            $regMethod = ucfirst($namespace);

            // Lets check if its already loaded
            if (($return = Registry::getInstance()->$regMethod($name)) !== false) {
                return $return;
            }

            // File Location, shared/non-shared
            $file = ($shared === false) ? Panda::getInstance()->appRoot . $namespace . '/' . $name . '.php' : Panda::getInstance()->root . 'Shared/' . $namespace . '/' . $name . '.php';

            if (is_readable($file)) {
                require_once $file;

                $class = $namespace . '\\' . $name;

                if ($shared !== false) {
                    $name .= '__shared';
                }

                return Registry::getInstance()->$regMethod($name, new $class);
            }

            throw new FactoryException('Panda could not load the ' . substr($namespace, 0, -1) . ' with the name ' . $name, 500, null);
        }

    }

    