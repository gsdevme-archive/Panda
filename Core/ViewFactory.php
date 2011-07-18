<?php

    namespace Core;

use Core\Exceptions\ViewException as ViewException;

    class ViewFactory
    {

        private static $_instance;
        private $_views;
        private $_currentView;

        private function __construct()
        {
            $this->_views = array();
        }

        /**
         * Returns instance
         * @return type 
         */
        public static function getInstance()
        {
            if (!self::$_instance instanceof self) {
                self::$_instance = new self;
            }

            return self::$_instance;
        }

        /**
         * Add a view to the ADT Queue
         * @param string $name
         * @param array $data
         * @param bool $shared 
         */
        public function addView($name, array $args=null, $shared=false)
        {
            if ($shared === true) {
                $file = Panda::getInstance()->root . '/Shared/Views/' . $name . '.php';
            } else {
                $file = Panda::getInstance()->appRoot . 'Views/' . $name . '.php';
            }

            // Checksum
            $this->_currentView = sprintf('%u', crc32($file));

            if (!isset($this->_views[$this->_currentView])) {
                if (is_readable($file)) {
                    $this->_views[$this->_currentView] = ( object ) array('file' => $file, 'args' => $args, 'name' => $name);
                    return self::$_instance;
                }

                throw new ViewException('Failed to load view, could not find ' . $view->name, 404, null);
            }

            return self::$_instance;
        }

        /**
         * Render all views 
         * @return type 
         */
        public function render($cache=false, $xssfilter=true)
        {
            if (!empty($this->_views)) { 
                // Try and load a cache file
                if ($cache === true) {
                    $checksum = sprintf('%u', crc32(serialize($this->_views)));
                    $cacheFile = Panda::getInstance()->appRoot . 'Cache/' . $checksum . '.html';

                    if (is_readable($cacheFile)) {
                        require $cacheFile;
                        return true;
                    }
                }
                
                // Create a cache filer
                if($cache === true){
                    $appRoot = Panda::getInstance()->appRoot;
                    
                    ob_start(function($buffer) use ($appRoot, $checksum, $cacheFile){
                        $file = new \SplFileObject($cacheFile, 'w');
                        $file->fwrite($buffer);
                        return $buffer;
                    });
                }

                // Load each view
                foreach ($this->_views as $view) {
                    new View($view->file, $view->args, $xssfilter);
                }

                return true;
            }

            throw new ViewException('No views where found, make sure you use $this->view() before $this->render()');
        }

        /**
         * Add values to argument array
         * @param string $property
         * @param type $value 
         */
        private function _args($property, $value)
        {
            if (isset($this->_views[$this->_currentView])) {
                $this->_views[$this->_currentView]->args[$property] = $value;
            }
        }

        /**
         * Add values to argument array
         * @param string $property
         * @param type $value 
         */
        private function _argsArray(array $args)
        {
            if (isset($this->_views[$this->_currentView])) {
                $this->_views[$this->_currentView]->args = array_merge($this->_views[$this->_currentView]->args, $args);
            }
        }

        /**
         * To overload _args() and argsArray()
         * @param type $method
         * @param type $args
         * @return type 
         */
        public function __call($method, $args)
        {
            if (($method === 'args') && (isset($args[0]))) {
                if ((!is_array($args[0])) && (isset($args[1]))) {
                    return $this->_args($args[0], $args[1]);
                }

                return $this->_argsArray($args[0]);
            }
        }

    }