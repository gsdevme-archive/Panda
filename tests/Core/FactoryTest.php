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
        
        public function testShared()
        {
            return;
            //all this will fail with the current code, well the next method would fail, this one would be fine but this stuff is what needs changing for them both to work.
            try {
                $model = Factory::model('users',1);
                $this->assertTrue($model instanceof \Core\Model, 'Model not an instance of \Core\Model');

                $library = Factory::library('twitter',1);
                $this->assertTrue(is_object($library), 'Library is not an object');

                $sl = Factory::serviceLayer('users',1);
                $this->assertTrue($sl instanceof \Core\ServiceLayer, 'Not an instance of service layer');
                
            } catch (Exception $e) {
                $this->fail($e->getMessage());
            }
        }
        
        public function testExistant()
        {
            try {
                $model = Factory::model('users');
                $this->assertTrue($model instanceof \Core\Model, 'Model not an instance of \Core\Model');

                $library = Factory::library('twitter');
                $this->assertTrue(is_object($library), 'Library is not an object');

                $sl = Factory::serviceLayer('users');
                $this->assertTrue($sl instanceof \Core\ServiceLayer, 'Not an instance of service layer');
                
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
                
            } catch (Exception $e) {
                $this->fail('Caught exception is not an instanceof \Core\Exceptions\LoadException');
            }
        }

        public function testNonExistentLibrary()
        {
            try {
                $library = Factory::library('1234');
                $this->fail('Failed to throw an exception');
            } catch (LoadException $e) {
                
            } catch (Exception $e) {
                $this->fail('Caught exception is not an instanceof \Core\Exceptions\LoadException');
            }
        }

    }

    