<?php

    use PHPUnit_Framework_TestCase as PHPUnit;

    class ControllerFactoryTest extends PHPUnit
    {

        public function setup()
        {
            $config = new stdClass;

            $config->defaultApp = 'Index';
            $config->debug = true;
            $config->defaultController = 'Index';
            $config->defaultMethod = 'Index';
            $config->mode = 'HTTP';
            $config->appRoot = \Core\Panda::getInstance()->root . 'Index/';

            \Core\Panda::getInstance()->import($config);
        }

        public function testInvoke()
        {
            try {
                $class = new ReflectionClass('\\Controllers\Index');
                $method = new ReflectionMethod($class->name, 'index');
                
                $return = new \Core\ControllerFactory($class, $method, null);
            } catch (\Exception $e) {
                $this->fail($e);
            }
        }

        public function testInvokeWithReoute()
        {
            try {                
                $return = \Core\ControllerFactory::route('Index', 'Index');
            } catch (\Exception $e) {
                $this->fail($e);
            }
        }

        public function testInvokeWithWrongParams()
        {
            try {
                $return = \Core\ControllerFactory::route('BillBob', 'Index');
                
                $this->fail('Failed, as the ControllerFactory didnt error');
            } catch (\Exception $e) {
                
            }
        }

        public function testInvokeWithWrongParamsAgain()
        {
            try {
                $return = \Core\ControllerFactory::route('Dummy', 'Index');
                
                $this->fail('Failed, as the ControllerFactory didnt error');
            } catch (\Exception $e) {
                
            }
        }

        public function testInvokeWithNonInstantiable()
        {
            try {
                $return = \Core\ControllerFactory::route('Controller', 'Index');
                
                $this->fail('Failed, as the ControllerFactory didnt error');
            } catch (\Exception $e) {
                
            }
        }

    }