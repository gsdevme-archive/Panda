<?php

    namespace Core;

use Core\Exceptions\FactoryException as FactoryException;
use \ReflectionClass as ReflectionClass;
use \ReflectionException as ReflectionException;

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
            $model = self::_loader(ucfirst($name), 'Models', $shared);

            // Check if its parent is a Model
            if ($model instanceof Model) {
                return $model;
            }

            throw new FactoryException($name . ' is not an instance of \Core\Model');
        }

        /**
         * Load a library
         * @param string $name name of the library
         * @param bool $shared is this a shared library?
         * @return object
         */
        public static function library($name, $shared = false)
        {
            return self::_loader(ucfirst($name), 'Libraries', $shared);
        }

        /**
         * load a service layer
         * @param type $name
         * @param type $shared
         * @return ServiceLayer 
         */
        public static function serviceLayer($name, $shared = false)
        {
            $sl = self::_loader(ucfirst($name), 'ServiceLayers', $shared);

            // Check if its parent is a ServiceLayer
            if ($sl instanceof ServiceLayer) {
                return $sl;
            }

            throw new FactoryException($name . ' is not an instance of \Core\ServiceLayer');
        }

        /**
         * load a helper
         * @param type $name
         * @param type $shared
         * @return type 
         */
        public static function helper($name, $shared = false)
        {
            return self::_loader(ucfirst($name), 'Helpers', $shared);
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
            $regMethod = $namespace;
            $instance = ($shared === true) ? $name . '__shared' : $name;

            // Lets check if its already loaded
            if (($return = Registry::getInstance()->$regMethod($instance)) !== false) {
                return $return;
            }

            // File Location, shared/non-shared
            $file = ($shared === true) ? Panda::getInstance()->root . 'Shared/' . $namespace . '/' . $name . '.php' : Panda::getInstance()->appRoot . $namespace . '/' . $name . '.php';

            if (is_readable($file)) {
                require_once $file;
                $class = $namespace . '\\' . $name;
                
                try {
                    $class = new ReflectionClass($class);
                    
                    if($class->isInstantiable()){
                        return Registry::getInstance()->$regMethod($instance, $class->newInstance());
                    }
                    
                    $class = $class->name;                    
                    return Registry::getInstance()->$regMethod($instance, $class::getInstance());                    
                } catch (ReflectionException $e) {
                    
                }                
            }

            throw new FactoryException('Panda could not load the class ' . $namespace . '\\' . $name, 500, ifsetor($e, null));
        }

    }

    