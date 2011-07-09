<?php

    namespace Core;

use \ReflectionClass as ReflectionClass;
use \ReflectionMethod as ReflectionMethod;

    class ControllerFactory
    {
        /**
         * Invokes the controller 
         * @param ReflectionClass $class
         * @param ReflectionMethod $method
         * @param array $args
         * @return type 
         */
        public function __construct(ReflectionClass $class, ReflectionMethod $method, array $args=null){
            if($args === null){
                return $method->invoke($class->newInstance(), null);
            }
            
            return $method->invokeArgs($class->newInstance(), $this->_urldecode($args));
        }
        
        /**
         * Perhaps a URL decode on each argument
         * @param array $args
         * @return array 
         */
        private function _urldecode(array $args){
            foreach($args as $arg){
                $arg = urldecode($arg);
            }
            
            return $args;
        }
    }

?>
