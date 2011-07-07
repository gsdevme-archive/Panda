<?php

    namespace Core;

    class Request
    {

        private $_request, $_virtualHost;

        /**
         * Parse and Find the Controller/Method/Args
         */
        public function __construct()
        {
            /*
             * Command Line Detection
             * php -f index.php controller/method/args virtualhost
             */
            if ((defined('PHP_SAPI')) && (PHP_SAPI === 'cli')) {
                if (isValue($_SERVER['argv'][1])) {
                    $request = $_SERVER['argv'][1];

                    if (isValue($_SERVER['argv'][2])) {
                        $virtualhost = $_SERVER['argv'][2];
                    }
                }
            }

            /*
             * Http Detection
             * http://virtualhost/index.php/controller/method/args
             */
            if (isValue($_SERVER['REQUEST_URI'])) {
                $_SERVER['REQUEST_URI'] = substr(str_replace($_SERVER['SCRIPT_NAME'], null, $_SERVER['REQUEST_URI']), 1);
                
                if(isValue($_SERVER['REQUEST_URI'])){
                    $request = $_SERVER['REQUEST_URI'];
                }
            }

            $this->_request = ifsetor($request, 'Index/Index');
            $this->_virtualHost = ifsetor($virtualhost, 'Index');
        }

        public function getRequest()
        {
            return $this->_request;
        }

        public function getVirtualHost()
        {
            return $this->_virtualHost;
        }

    }