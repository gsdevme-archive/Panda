<?php

    namespace System\Panda;

    use \Exception;
    use \System\Panda\Exceptions\ModuleException;
    use \ReflectionClass;
    use \ReflectionMethod;

    abstract class Model
    {

        final public function __get($name)
        {
            return $this->component($name);
        }

        final protected function component($name)
        {
            try {
                $class = '\System\Components\\' . ucfirst($name);                
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

    