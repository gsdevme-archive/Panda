<?php

    use PHPUnit_Framework_TestCase as PHPUnit;

    class ViewFactory extends PHPUnit
    {

        private $_view;

        public function setup()
        {
            $config = new stdClass;
            $this->_view = \Core\ViewFactory::getInstance();

            $config->defaultApp = 'Index';
            $config->debug = true;
            $config->defaultController = 'Index';
            $config->defaultMethod = 'Index';
            $config->mode = 'HTTP';
            $config->appRoot = \Core\Panda::getInstance()->root . 'Index/';

            \Core\Panda::getInstance()->import($config);
        }

        public function testRenderWithNoViews()
        {
            try {
                $this->_view->render();
                $this->fail('Failed to throw an exception');
            } catch (\Exception $e) {
                
            }
        }

        public function testSharedView()
        {
            if ($this->_view->addView('dummy', null, true) instanceof \Core\ViewFactory) {
                return;
            }

            $this->fail('Did not return instance of itself');
        }

        public function testAppView()
        {
            if ($this->_view->addView('index', null) instanceof \Core\ViewFactory) {
                return;
            }

            $this->fail('Did not return instance of itself');
        }

        public function testAppViewArgs()
        {
            if ($this->_view->addView('index', array('data' => 1)) instanceof \Core\ViewFactory) {
                return;
            }

            $this->fail('Did not return instance of itself');
        }

        public function testAppViewArgsMultipleTimes()
        {
            if (!$this->_view->addView('index')->args('test', 'yes')) {
                $this->fail('Did not return instance of itself');
            }
        }

        public function testAppViewArgsMultipleTimesArray()
        {
            if (!$this->_view->addView('index')->args(array('foo' => 1))) {
                $this->fail('Did not return instance of itself');
            }
        }

        public function testNonExistView()
        {
            try {
                $this->_view->addView('iffff');
                $this->fail('Did not return instance of itself');
            } catch (\Exception $e) {
                
            }
        }

        public function testMethodOverload()
        {
            try {
                $this->_view->foobar();
                $this->fail('Did not overload');
            } catch (\Exception $e) {
                
            }
        }

        public function testRender()
        {
            $this->_view->render();
        }

    }

    