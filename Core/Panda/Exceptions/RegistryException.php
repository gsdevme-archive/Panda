<?php

    namespace Core\Panda\Exceptions;

    class RegistryException extends ExceptionAbstract
    {

        public function __construct($message, $code=null, \Exception $previous=null)
        {
            parent::__construct($message, $code, $previous);
        } 

    }