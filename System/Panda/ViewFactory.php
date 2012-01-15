<?php

    namespace System\Panda;

    use Exceptions\ViewException;
    use \SplFileObject;

    class ViewFactory
    {

        protected $views, $currentView, $panda;

        private function __construct()
        {
            $this->views = array();
            $this->panda = Panda::getInstance();
        }

        /**
         * Returns instance
         * @return type 
         */
        public static function getInstance()
        {
            if (!static::$_instance instanceof static) {
                static::$_instance = new static;
            }

            return static::$_instance;
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
                $file = $this->panda->root . '/Shared/Views/' . $name . '.php';
            } else {
                $file = $this->panda->appRoot . 'Views/' . $name . '.php';
            }

            // Checksum
            $this->_currentView = sprintf('%u', crc32($file));

            if (!isset($this->views[$this->_currentView])) {
                if (is_readable($file)) {
                    $this->views[$this->_currentView] = ( object ) array('file' => $file, 'args' => $args, 'name' => $name);
                    return static::$_instance;
                }

                throw new ViewException('Failed to load view, could not find ' . $name, 404, null);
            }

            return static::$_instance;
        }

        /**
         * Render all views 
         * @return type 
         */
        public function render($cache=false, $xssfilter=true, array $headers=null)
        {
            if (!empty($this->views)) {
                if ($headers !== null) {
                    foreach ((array)$headers as $header) {
                        header($header);
                    }
                }

                // Try and load a cache file and check the etag
                if ($cache === true) {
                    $checksum = sprintf('%u', crc32(serialize($this->views)));
                    header('ETag: ' . $checksum);

                    $cacheFile = $this->panda->appRoot . 'ViewCache/' . $checksum . '.html';
                    $readable = ( bool ) is_readable($cacheFile);

                    // Check if the user already has it
                    if (($readable) && (isset($_SERVER['HTTP_IF_NONE_MATCH'])) && ($_SERVER['HTTP_IF_NONE_MATCH'] == $checksum)) {
                        header("HTTP/1.1 304 Not Modified");
                        return;
                    }

                    // Check if we have a cached HTML
                    if ($readable) {
                        // Start buffer output, just incase we need to capture any errors
                        ob_start();

                        require $cacheFile;
                        return;
                    }

                    $appRoot = $this->panda->appRoot;

                    ob_start(function($buffer) use ($appRoot, $checksum, $cacheFile) {
                            // Check can we create a cached HTML
                            if (!is_writable($appRoot . 'ViewCache')) {
                                // Change the ETag so the user isn't stuck with a broken page
                                header('ETag: ' . 'error');
                                
                                // Since we cant throw within an ob_start, its best to just return a simple error
                                return 'ViewCache folder is not writeable, either disable viewCache or make it writeable..';
                            }

                            // Minify
                            $minify = new Minify($buffer);
                            $buffer = $minify->process();

                            //Write File
                            $file = new SplFileObject($cacheFile, 'w');
                            $file->fwrite($buffer);
                            return $buffer;
                        }, 0, true);
                } else {
                    // Start buffer output, just incase we need to capture any errors
                    ob_start();
                }

                // Load each view
                foreach ($this->views as $view) {
                    new \System\View($view->file, $view->args, $xssfilter);
                }

                return true;
            }

            throw new ViewException('No views where found, make sure you use $this->view() before $this->render()', 404);
        }

        /**
         * Add values to argument array
         * @param string $property
         * @param type $value 
         */
        private function _args($property, $value)
        {
            return $this->views[$this->_currentView]->args[$property] = $value;
        }

        /**
         * Add values to argument array
         * @param string $property
         * @param type $value 
         */
        private function _argsArray(array $args)
        {
            return $this->views[$this->_currentView]->args = array_merge($this->views[$this->_currentView]->args, $args);
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
                if (!is_array($args[0])) {
                    return $this->_args($args[0], $args[1]);
                }

                return $this->_argsArray($args[0]);
            }

            throw new ViewException('Failed to call method ' . $method . ' it does not exist', 500);
        }

        /**
         * Checks if an argument is set within the current view
         * @param string $name
         * @return bool 
         */
        public function __isset($name)
        {
            return ( bool ) isset($this->views[$this->_currentView]->args[$name]);
        }

    }