<?php

    namespace Core\Panda;

    class Request
    {

        private $_request, $_app;

        /**
         * Parse and Find the App - Controller/Method/Args
         * @param string $request 
         */
        public function __construct()
        {
            /*
             * Command Line Detection
             * php -f index.php controller/method/args app
             */
            if ((defined('PHP_SAPI')) && (PHP_SAPI === 'cli')) {
                Panda::getInstance()->mode = 'CLI';

                if (isValue($_SERVER['argv'][1])) {
                    $_SERVER['argv'][1] = $this->_clean($_SERVER['argv'][1]);

                    $request = ifvalueor($_SERVER['argv'][1], null);

                    if (isValue($_SERVER['argv'][2])) {
                        $app = $_SERVER['argv'][2];
                    }
                }
            }

            /*
             * Http Detection
             * http://app/index.php/controller/method/args
             */
            if (isValue($_SERVER['REQUEST_URI'])) {
                Panda::getInstance()->mode = 'HTTP';

                $_SERVER['REQUEST_URI'] = substr(str_replace($_SERVER['SCRIPT_NAME'], null, $_SERVER['REQUEST_URI']), 1);
                $_SERVER['REQUEST_URI'] = $this->_clean($_SERVER['REQUEST_URI']);

                if (isValue($_SERVER['REQUEST_URI'])) {
                    $request = $_SERVER['REQUEST_URI'];
                }

                if ((isValue($_SERVER['HTTP_HOST'])) && (!filter_var($_SERVER['HTTP_HOST'], FILTER_VALIDATE_IP))) {
                    /*
                     * Remove everything but A-Z, 0-9 and Uppercase each Word
                     * i.e. apps.facebook.com = AppsFacebookCom
                     */
                    $app = str_replace(' ', null, ucwords(preg_replace("/[^A-Z0-9]+/i", ' ', $_SERVER['HTTP_HOST'])));

                    // Check the first letter is a valid one
                    if (ord(substr($app, 0, 1)) < 65) {
                        $app = null;
                    }
                }
            }
            
            $this->_request = ifsetor($request, null);
            $this->_app = ifsetor($app, Panda::getInstance()->defaultApp);
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
        public function getApp()
        {
            return $this->_app;
        }

        private function _clean($value)
        {
            // Remove / Prefix
            if (substr($value, 0, 1) == '/') {
                $value = substr($value, 1);
            }

            // Remove / Suffix
            if (substr($value, strlen($value) - 1, 1) == '/') {
                $value = substr($value, 0, strlen($value) - 1);
            }

            return $value;
        }

    }

    