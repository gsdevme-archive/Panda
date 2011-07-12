<?php

    namespace Core;

use Core\Exceptions\ViewException as Exception;

    class View
    {

        private $_panda;
        private $_registry;
        private $_file;
        private $_args;

        public function __construct()
        {
            $this->_panda = Panda::getInstance();
            $this->_registry = Registry::getInstance();
        }

        /**
         * Load a view
         * @param string $name name of the view
         * @param array $args array of arguments
         * @param bool $shared is this a shared view?
         * @return type 
         */
        public function load($name, array $args = null, $shared = false)
        {
            if ($shared === false) {
                $file = $this->_panda->root . '/Shared/Views/' . $name . '.php';
            } else {
                $file = $this->_panda->appRoot . 'Views/' . $name . '.php';
            }

            if (is_readable($file)) {
                $this->_file = $file;
                $this->_args = $args;
                return $this;
            }
            throw new Exception('Failed to load ' . $name. ' - '.$file);
        }
        
        /**
         * Add arguments to the view
         * @param type $x
         * @param type $z 
         */
        public function args($x, $z = false)
        {
            if (is_array($x)) {
                array_merge($this->_args, $z);
            } elseif (isset($x, $z)) {
                $this->_args[$x] = $z;
            }
        }
        
        /**
         * Render a view
         * @return View 
         */
        public function render()
        {
            if (is_array($this->_args)) {
                extract($this->_args);
            }
            require $this->_file;
            return $this;
        }
        
        /**
         * Load an element
         * @param type $name
         * @param type $shared 
         */
        public function element($name, $shared = false)
        {
            if ($shared === true) {
                $file = $this->_panda->root . '/Shared/Elements/' . $name . '.php';
            } else {
                $file = $this->_panda->appRoot . 'Elements/' . $name . '.php';
            }
            if(is_readable($file)){
                //give the element access to this views args
                if(is_array($this->_args)){
                    extract($this->_args);
                }
                require $file;
            }else{
                throw new Exception('Element not found - '.$file);
            }
        }

    }