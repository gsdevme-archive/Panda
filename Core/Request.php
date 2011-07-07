<?php

    namespace Core;

    class Request
    {

        private $_request, $_virtualHost;

        /**
         * Parse and Find the Controller/Method/Args
         * @param string $request 
         */
        public function __construct($request=null, $virtualHost=null)
        {
            if ($request === null) {
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

                    if (isValue($_SERVER['REQUEST_URI'])) {
                        $request = $_SERVER['REQUEST_URI'];
                    }

                    if ((isValue($_SERVER['HTTP_HOST'])) && (!filter_var($_SERVER['HTTP_HOST'], FILTER_VALIDATE_IP))) {
                        /*
                         * Remove everything but A-Z, 0-9 and Uppercase each Word
                         * i.e. apps.facebook.com = AppsFacebookCom
                         */
                        $virtualHost = str_replace(' ', null, ucwords(preg_replace("/[^A-Z0-9]+/i", ' ', $_SERVER['HTTP_HOST'])));

                        // Check the first letter is a valid one
                        if (ord(substr($virtualHost, 0, 1)) < 65) {
                            $virtualHost = null;
                        }
                    }
                }
            }

            $this->_request = ifsetor($request, 'Index/Index');
            $this->_virtualHost = ifsetor($virtualHost, 'Index');
        }

        /**
         * Common sense
         * @return string 
         */
        public function getRequest()
        {
            return $this->_request;
        }

        /**
         * Common sense
         * @return string 
         */
        public function getVirtualHost()
        {
            return $this->_virtualHost;
        }

    }