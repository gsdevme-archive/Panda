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