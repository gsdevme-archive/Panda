<?php

    namespace Core;

    class View
    {

        private $_args;

        /**
         * View class is set with the file and arguments it requires
         * @param string $file
         * @param array $args 
         */
        public function __construct($file, array $args=null, $xssfilter=true)
        {

            if ($args !== null) {
                if ($xssfilter === true) {
                    // Check if they have set a charset, if not default to UTF-8
                    $charset = (isset(Panda::getInstance()->defaultCharset)) ? Panda::getInstance()->defaultCharset : 'UTF-8';

                    $recursiveFilter = function(&$value, $key, $recursiveFilter) use ($charset) {
                            if (is_array($value)) {
                                array_walk($value, $recursiveFilter, $recursiveFilter);
                            } else {
                                $value = htmlspecialchars(htmlentities(trim(($value)), ENT_QUOTES, $charset, false), ENT_QUOTES, $charset, false);
                            }
                        };

                    array_walk($args, $recursiveFilter, $recursiveFilter);
                }

                $this->_args = $args;

                extract($this->_args);
            }

            require $file;
        }

        /**
         * Load an element
         * @param string $name
         * @param bool $shared 
         */
        public function element($name, $shared = false)
        {
            if ($shared === true) {
                $file = Panda::getInstance()->root . '/Shared/Elements/' . $name . '.php';
            } else {
                $file = Panda::getInstance()->appRoot . 'Elements/' . $name . '.php';
            }

            if (is_readable($file)) {
                if (is_array($this->_args)) {
                    //extract($this->_args);
                }
                require $file;
            } else {
                throw new Exception('Element not found - ' . $file);
            }
        }

    }