<?php

    namespace Core;

use \Exception as Exception;
use \Core\Exceptions\ModuleException as ModuleException;
use \ReflectionClass as ReflectionClass;
use \ReflectionMethod as ReflectionMethod;

    abstract class Model
    {

        /**
         *
         * @param type $name
         * @return type 
         */
        public function __get($name)
        {
            return $this->modules($name);
        }

        final protected function modules($name)
        {
            try {
                $class = '\Modules\\' . ucfirst($name);                
                $class = new ReflectionClass($class);

                if ($class->isInstantiable()) {
                    return $class->newInstance();
                }

                if ($class->hasMethod('getInstance')) {
                    $class = $class->name;
                    return $class::getInstance();
                }
            } catch (Exception $e) {
            }

            throw new ModuleException('Panda failed to load module ' . ucfirst($name), 500, ifsetor($e, null));
        }

    }

    