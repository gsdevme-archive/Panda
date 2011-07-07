<?php

    namespace Core\Exceptions;

    class RegistryException extends ExceptionAbstract
    {

        public function __construct($message, $code=null, \Exception $previous=null)
        {
            parent::__construct($message, $code, $previous);
        } 

    }