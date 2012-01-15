<?php

    namespace System\Panda\Exceptions;

    class FactoryException extends ExceptionAbstract
    {

        public function __construct($message, $code=null, \Exception $previous=null)
        {
            parent::__construct($message, $code, $previous); 
        } 

    }