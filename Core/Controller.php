<?php

    namespace Core;

use \Core\Exceptions\Load as LoadException;

    abstract class Controller
    {

        private $_registry;
        private $_panda;

        abstract public function index();

        public function __construct()
        {
            $this->_registry = Registry::getInstance();
            $this->_panda = Panda::getInstance();
        }

        final protected function model($name, $shared = false)
        {
            if ($this->_registry->model($name)) {
                return $this->_registry->model($name);
            } else {
                $file = ($shared === false) ? $this->_panda->appRoot . 'Models/' : $this->_panda->root . 'Shared/Models/';
                $file.=$name . '.php';
                
                if(is_readable($file)){
                    require_once $file;
                    
                    $class = 'Models\\'.ucfirst($name);
                    
                    $name .= ($shared == true) ? '__shared' : '';
                    
                    return $this->_registry->model($name,new $class);
                }
            }
            throw new LoadException('Model not found');
        }

        final protected function library($name)
        {
            
        }

        final protected function serviceLayer($name)
        {
            
        }

    }

    