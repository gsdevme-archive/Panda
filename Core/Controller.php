<?php

    namespace Core;

    use  \Core\Exceptions\Load as LoadException;
    
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

        final protected function model($name)
        {
            if($this->_registry->model($name)){
                return $this->_registry->model($name);
            }else{
                echo '<pre>' . print_r($this->_panda, 1) . '</pre>';
                return;
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

    