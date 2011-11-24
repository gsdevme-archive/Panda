<?php

    namespace Core\Panda;

use \ReflectionClass as ReflectionClass;
use \ReflectionMethod as ReflectionMethod;
use \ReflectionException as ReflectionException;
use Core\Exceptions\RouterException as RouterException;

    class ControllerFactory
    {

        /**
         * Invokes the controller 
         * @param ReflectionClass $class
         * @param ReflectionMethod $method
         * @param array $args
         * @return type 
         */
        public function __construct(ReflectionClass $class, ReflectionMethod $method, array $args=null)
        {
            if ($args === null) {
                return $method->invoke($class->newInstance(), null);
            }

            return $method->invokeArgs($class->newInstance(), $this->_urldecode($args));
        }

        /**
         * Invokes a controller, this should be used to re-route 
         * @param string $controller
         * @param string $method
         * @param array $args 
         */
        public static function route($controller, $method='index', array $args=null)
        {

            try {
                $class = new ReflectionClass('Controllers\\' . ucfirst($controller));
                $method = new ReflectionMethod($class->name, $method);

                if ((Panda::getInstance()->mode == 'HTTP') && ($class->getParentClass()->name != 'Controllers\Controller')) {
                    throw new RouterException('This controller is for CLI use only, Controller: ' . ucfirst($controller), 404);
                }

                if (($method->isPublic()) && (!$method->isConstructor())) {
                    return new self($class, $method, $args);
                }
            } catch (ReflectionException $e) {
                
            }

            throw new RouterException('Panda failed the find the controller or method, with the name ' . ucfirst($controller), 404, ifsetor($e, null));
        }

        /**
         * Perhaps a URL decode on each argument
         * @param array $args
         * @return array 
         */
        private function _urldecode(array $args)
        {
            $count = count($args);

            for ($i = 0; $i < $count; ++$i) {
                $args[$i] = urldecode($args[$i]);
            }

            return $args;
        }

    }

?>
