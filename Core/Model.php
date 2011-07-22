<?php

    namespace Core;

use \Exception as Exception;
use \Core\Exceptions\ModuleException as ModuleException;
use \ReflectionClass as ReflectionClass;
use \ReflectionMethod as ReflectionMethod;

    abstract class Model
    {

        private $_registry;

        public function __construct()
        {
            $this->_registry = Registry::getInstance();
        }

        /**
         *
         * @param type $name
         * @return type 
         */
        public function __get($name)
        {
            return $this->modules($name);
        }

        public function modules($name)
        {
            if (($module = $this->_registry->modules($name))) {
                return $module;
            }

            try {
                $class = '\Etc\Modules\\' . ucfirst($name);
                $class = new ReflectionClass($class);

                if ($class->isInstantiable()) {
                    return $this->_registry->modules($name, $class->newInstance());
                }

                if ($class->hasMethod('getInstance')) {
                    $class = $class->name;
                    return $this->_registry->modules($name, $class::getInstance());
                }
            } catch (Exception $e) {

            }

            throw new ModuleException('Panda failed to load module ' . ucfirst($name), 500, ifsetor($e, null));
        }

    }

    