<?php

    namespace Core;

    class Registry extends RegistryAbstract
    {
        
        private $_models;
        
        private $_libraries;
        
        private $_serviceLayers;
        
        public function __construct()
        {
            parent::__construct();
            $this->_model = new \SplObjectStorage();
        }
        public function model($name,$value = false)
        {
            if(isset($value)){
                
            }
        }
    }

    