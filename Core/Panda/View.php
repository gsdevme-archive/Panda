<?php

    namespace Core\Panda;
    
    use \Exception as Exception;

    class View
    {

        private $_args;

        /**
         * View class is set with the file and arguments it requires
         * @param string $file
         * @param array $args 
         * @param bool $xssFilter
         */
        public function __construct($file, array $args=null, $xssFilter=true)
        {

            if ($args !== null) {
                if ($xssFilter === true) {
                    // Check if they have set a charset, if not default to UTF-8
                    $charset = (isset(Panda::getInstance()->defaultCharset)) ? Panda::getInstance()->defaultCharset : 'UTF-8';

                    $recursiveFilter = function(&$value, $key, $recursiveFilter) use ($charset) {
                            switch (gettype($value)) {
                                case "object":
                                case "array":
                                    array_walk($value, $recursiveFilter, $recursiveFilter);
                                    break;
                                case "string":
                                    $value = ( string ) htmlspecialchars(htmlentities(trim(($value)), ENT_QUOTES, $charset, false), ENT_QUOTES, $charset, false);
                                    break;
                                case "bool":
                                    $value = ( bool ) $value;
                                    break;
                                default:
                                    // Do nothing, as we dont know whats going on
                                    break;
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
                    extract($this->_args);
                }
                require $file;
            } else {
                throw new Exception('Element not found - ' . $file);
            }
        }

        /**
         * Load a helper
         * @param type $name
         * @param type $helper 
         */
        public function helper($name, $shared=false)
        {
            return Factory::helper($name, $shared);
        }

    }