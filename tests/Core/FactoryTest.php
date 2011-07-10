<?php

    use \Core\Registry as Registry;
use \Core\Panda as Panda;
use \Core\Factory as Factory;
use \Core\Exceptions\LoadException as LoadException;
use PHPUnit_Framework_TestCase as PHPUnit;

    class FactoryTest extends PHPUnit
    {

        private $_panda;
        private $_registry;

        public function setUp()
        {
            $this->_panda = Panda::getInstance();
            $this->_panda->appRoot = $this->_panda->root . 'Index/';
            $this->_registry = Registry::getInstance();
        }

        public function testModel()
        {
            try {
                $model = Factory::model('users');
                $this->assertTrue($model instanceof \Core\Model,'Model not an instance of \Core\Model');
            } catch (Exception $e) {
                $this->fail($e->getMessage());
            }
        }

        public function testNonExistentModel()
        {
            try {
                $model = Factory::model('1234');
                 $this->fail('Failed to throw an exception');
            } catch (LoadException $e) {
                
            } catch (Exception $e){
                $this->fail('Caught exception is not an instanceof \Core\Exceptions\LoadException');
            }
        }

    }

    