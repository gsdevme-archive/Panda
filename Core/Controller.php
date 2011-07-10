<?php

    namespace Core;

use \Core\Exceptions\Load as LoadException;

    abstract class Controller
    {

        private $_registry;
        private $_panda;
        private $_view;

        abstract public function index();

        public function __construct()
        {
            $this->_registry = Registry::getInstance();
            $this->_panda = Panda::getInstance();
            $this->_view = new View;
        }

        final protected function model($name, $shared = false)
        {
            return $this->_loader($name, 'models', $shared);
        }

        final protected function library($name, $shared = false)
        {
            return $this->_loader($name, 'libraries', $shared);
        }

        final protected function serviceLayer($name, $shared = false)
        {
            return $this->_loader($name, 'serviceLayers', $shared);
        }
        final protected function view($name,array $args = null,$shared = false)
        {
            $this->_view->load($name,$args,$shared);
        }
        /**
         * Slightly difficult to read but saves a fuck-ton of code
         * @param type $name
         * @param type $type
         * @param type $shared
         * @return type 
         */
        private function _loader($name, $type, $shared = false)
        {
            //type is going to be something like model or library
            $regMethod = $type;
            $dir = ucfirst($type);

            if ($this->_registry->$regMethod($name)) {
                return $this->_registry->$regMethod($name);
            } else {
                $file = ($shared === false) ? $this->_panda->appRoot . $dir . '/' : $this->_panda->root . 'Shared/' . $dir . '/';
                $file.=$name . '.php';
                
                if (is_readable($file)) {
                    require_once $file;

                    $class = $dir . '\\' . ucfirst($name);

                    $name .= ( $shared == true) ? '__shared' : '';

                    return $this->_registry->$regMethod($name, new $class);
                }
            }
            throw new LoadException('_loader error Model not found');
        }

    }

    