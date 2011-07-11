<?php

    use PHPUnit_Framework_TestCase as PHPUnit;

    class RouterTest extends PHPUnit
    {

        public function __construct()
        {
            // Removes Unit testing info
            $_SERVER['argv'] = array();

            // Adds server params needed
            $_SERVER['SCRIPT_NAME'] = 'index.php';
        }

        public function setUp()
        {
        }

        /**
         * Lets test if we can load a controller
         */
        public function testRouterBasics()
        {
            try {
                $_SERVER['REQUEST_URI'] = 'index.php/index/index';
                $router = new Core\Router(new Core\Request());

                if (!class_exists('Controllers\Index', false)) {
                    throw new Exception('Didnt load a controller');
                }
            } catch (Exception $e) {
                $this->fail($e);
            }
        }
        /**
         * Lets test if we can load a controller without a method
         */
        public function testRouterBasicsNoMethod()
        {
            try {
                $_SERVER['REQUEST_URI'] = 'index.php/index/';
                $router = new Core\Router(new Core\Request());

                if (!class_exists('Controllers\Index', false)) {
                    throw new Exception('Didnt load a controller');
                }
            } catch (Exception $e) {
                $this->fail($e);
            }
        }

        /**
         * Lets test if we can load a controller with args
         */
        public function testRouterBasicsArgs()
        {
            try {
                $_SERVER['REQUEST_URI'] = 'index.php/index/index/hello';
                $router = new Core\Router(new Core\Request());

                if (!class_exists('Controllers\Index', false)) {
                    throw new Exception('Didnt load a controller');
                }
            } catch (Exception $e) {
                $this->fail($e);
            }
        }

        /**
         * Lets test if we can load a controller without giving a REQUEST URI to the request class
         */
        public function testRouterBasicsNoRequestURI()
        {
            try {
                $_SERVER['REQUEST_URI'] = 'index.php';
                $router = new Core\Router(new Core\Request());

                if (!class_exists('Controllers\Index' , false)) {
                    throw new Exception('Didnt load a controller');
                }
            } catch (Exception $e) {
                $this->fail($e);
            }
        }

        /**
         * Lets test if we can load a none default app which is missing
         */
        public function testRouterNoConfig()
        {
            try {
                $_SERVER['argv'] = array('index.php', 'Index/Index', 'Bob');
                $_SERVER['REQUEST_URI'] = 'index.php';
                $router = new Core\Router(new Core\Request());
                
                $this->fail('Controller didnt throw an exception i.e. we failed...');
            } catch (Exception $e) {
                
            }
            
            //Reset
            $_SERVER['argv'] = array();
        }

        /**
         * This should fail as there is no such controller
         */
        public function testRouterFailures()
        {
            try {
                $_SERVER['REQUEST_URI'] = 'index.php/es5tye5mt085yt580yt580t/fdfgw3cr974gru7g';
                $router = new Core\Router(new Core\Request());
                $this->fail('Controller didnt throw an exception i.e. we failed...');
            } catch (Exception $e) {
                
            }
        }

        /**
         * This should fail as dummy controller is CLI only
         */
        public function testRouterCLILockedOut()
        {
            try {
                $_SERVER['REQUEST_URI'] = '';
                
                $_SERVER['argv'] = array('index.php', 'Dummy/Index', 'Index');
                $request = new Core\Request();                
                
                \Core\Panda::getInstance()->mode = 'HTTP';
                
                $router = new Core\Router($request);
                $this->fail('Controller didnt throw an exception i.e. we failed...');
            } catch (Exception $e) {
                
            }
        }

    }