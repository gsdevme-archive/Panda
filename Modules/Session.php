<?php

    namespace Modules;

use \Core\Panda\Panda as Panda;

    class Session
    {

        private static $_instance;

        /**
         * This method will load the session handler if needed and also start the session
         * @author Gavin Staniforth
         * @access public
         * @param SessionHandler $sessionHandler              
         * @return <instance>
         * @since 1.0
         */
        private function __construct()
        {
            if (isset(Panda::getInstance()->sessionClass)) {
                $sessionClass = '\Modules\\' . Panda::getInstance()->sessionClass;
                $sessionHandler = new $sessionClass;

                session_set_save_handler(
                    array($sessionHandler, 'open'), array($sessionHandler, 'close'), array($sessionHandler, 'read'), array($sessionHandler, 'write'), array($sessionHandler, 'destroy'), array($sessionHandler, 'gc')
                );
            }

            session_start();
            session_regenerate_id();
        }

        public static function getInstance()
        {
            if (!self::$_instance instanceof self) {
                self::$_instance = new self;
            }

            return self::$_instance;
        }

        /**
         * This method will get data from the session
         * @param <string> $name            
         * @return <string>
         */
        public function __get($name)
        {
            if (isset($_SESSION[$name])) {
                return $_SESSION[$name];
            }

            return ( bool ) false;
        }

        /**
         * This method will set data into a session
         * @param <string> $name            
         * @param <string> $value            
         * @return <bool>
         */
        public function __set($name, $value)
        {
            return $_SESSION[$name] = $value;
        }

        /**
         * This method is called upon unset($this->session->foo);
         * @param <string> $name  
         */
        public function __unset($name)
        {
            unset($_SESSION[$name]);
            return;
        }

        /**
         * This method is called upon isset($this->session->foo);
         * @param <string> $name  
         * @return <bool>
         */
        public function __isset($name)
        {
            return ( bool ) isset($_SESSION[$name]);
        }

    }

    