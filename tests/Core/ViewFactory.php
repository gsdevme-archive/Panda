<?php

    use PHPUnit_Framework_TestCase as PHPUnit;

    class ViewFactory extends PHPUnit
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

        public function testSharedView()
        {
            $view = \Core\ViewFactory::getInstance();

            if ($view->addView('dummy', null, true) instanceof \Core\ViewFactory) {
                return;
            }

            $this->fail('Did not return instance of itself');
        }

        public function testAppView()
        {
            $view = \Core\ViewFactory::getInstance();

            if ($view->addView('index', null) instanceof \Core\ViewFactory) {
                return;
            }

            $this->fail('Did not return instance of itself');
        }

        public function testAppViewArgs()
        {
            $view = \Core\ViewFactory::getInstance();

            if ($view->addView('index', array('data' => 1)) instanceof \Core\ViewFactory) {
                return;
            }

            $this->fail('Did not return instance of itself');
        }

        public function testAppViewArgsMultipleTimes()
        {
            $view = \Core\ViewFactory::getInstance();

            if (!$view->addView('index')->args('test', 'yes')) {
                $this->fail('Did not return instance of itself');
            }
        }

        public function testAppViewArgsMultipleTimesArray()
        {
            $view = \Core\ViewFactory::getInstance();

            if (!$view->addView('index')->args(array('foo' => 1))) {
                $this->fail('Did not return instance of itself');
            }
        }

        public function testNonExistView()
        {
            $view = \Core\ViewFactory::getInstance();

            try {
                $view->addView('iffff');
                $this->fail('Did not return instance of itself');
            } catch (\Exception $e) {
                
            }
        }

    }

    