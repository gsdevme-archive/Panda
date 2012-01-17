<?php

    namespace System\Panda;

    use \System\Panda\Exceptions\FactoryException;
    use \ReflectionClass;
    use \ReflectionException;

    /**
     * Static factory
     */
    class Factory
    {

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
         * @param array arguments for the library
         * @return object
         */
        public static function library($name, $shared = false, array $arguments = null)
        {
            return self::_loader(ucfirst($name), 'Libraries', $shared, $arguments);
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
        private static function _loader($name, $namespace, $shared = false, array $arguments = null)
        {
            $registryStore = ( bool ) ((isset(Panda::getInstance()->appRegistry)) && (Panda::getInstance()->appRegistry !== true));
            $regMethod = $namespace;
            $instance = ($shared === true) ? $name . '__shared' : $name;

            // Lets check if its already loaded
            if (($registryStore) && (($return = Registry::getInstance()->$regMethod($instance)) !== false)) {
                return $return;
            }

            // File Location, shared/non-shared
            $file = ($shared === true) ? Panda::getInstance()->root . 'Shared/' . $namespace . '/' . $name . '.php' : Panda::getInstance()->appRoot . $namespace . '/' . $name . '.php';

            if (is_readable($file)) {
                require_once $file;
                $class = $namespace . '\\' . $name;

                try {
                    $class = new ReflectionClass($class);

                    if ($class->isInstantiable()) {                        
                        $object = ($arguments === null) ? $class->newInstance() : $class->newInstanceArgs($arguments);
                    } else {
                        $class = $class->name;
                        $object = ($arguments === null) ? $class::getInstance() : $class->newInstanceArgs($arguments);
                    }
                    
                    if ($registryStore) {
                        return self::_registryStore($regMethod, $instance, $object);
                    }

                    return $object;
                } catch (ReflectionException $e) {
                    
                }
            }

            throw new FactoryException('Panda could not load the class ' . $namespace . '\\' . $name, 500, ifsetor($e, null));
        }

        /**
         * Method adds instances to the registry
         * @param string $method
         * @param string $instance
         * @param object $object
         * @return object 
         */
        private static function _registryStore($method, $instance, $object)
        {
            return Registry::getInstance()->$method($instance, $object);
        }

    }

    