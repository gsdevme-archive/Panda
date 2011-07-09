<?php

    use \Core\Request as Request;
use \Core\Panda as Panda;
use PHPUnit_Framework_TestCase as PHPUnit;

    class RequestTest extends PHPUnit
    {

        public function __construct()
        {
            // Removes Unit testing info
            $_SERVER['argv'] = array();

            // Adds server params needed
            $_SERVER['SCRIPT_NAME'] = 'index.php';
        }

        /**
         * Tests what happens if an Empty Request is sent
         */
        public function testEmptyRequest()
        {
            $request = new Request('');
            $this->assertEquals(Panda::getInstance()->defaultApp, $request->getApp());
            $this->assertEquals(null, $request->getRequest());
        }

        /**
         * Tests a standard URL request (mod_rewrite)
         */
        public function testStandardUrlRequest()
        {
            $_SERVER['REQUEST_URI'] = '/users/bill';

            $request = new Request();
            $this->assertEquals('users/bill', $request->getRequest());
        }

        /**
         * Tests a standard URL request (mod_rewrite)
         */
        public function testStandardUrlRequestAgain()
        {
            $_SERVER['REQUEST_URI'] = '/users/bill/';

            $request = new Request();
            $this->assertEquals('users/bill', $request->getRequest());
        }

        /**
         * Tests a standard URL request without mod_rewrite
         */
        public function testStandardUrlRequestNoRewrite()
        {
            $_SERVER['REQUEST_URI'] = '/index.php/users/bill';

            $request = new Request();
            $this->assertEquals('users/bill', $request->getRequest());
        }

        /**
         * Tests what the app name will be if domain is panda.com
         */
        public function testAppName()
        {
            $_SERVER['REQUEST_URI'] = '/';
            $_SERVER['HTTP_HOST'] = 'panda.com';

            $request = new Request();
            $this->assertEquals('PandaCom', $request->getApp());
            $this->assertEquals(null, $request->getRequest());
        }

        /**
         * Tests what the app name will be if domain is apps.facebook.com
         */
        public function testSubDomainAppName()
        {
            $_SERVER['REQUEST_URI'] = '/';
            $_SERVER['HTTP_HOST'] = 'apps.facebook.com';

            $request = new Request();
            $this->assertEquals('AppsFacebookCom', $request->getApp());
            $this->assertEquals(null, $request->getRequest());
        }

        /**
         * Tests app name with an invalid namespace name i.e. 55fish.com
         */
        public function testInvalidAppName()
        {
            $_SERVER['REQUEST_URI'] = '/';
            $_SERVER['HTTP_HOST'] = '55fish.com';

            $request = new Request();
            $this->assertEquals(Panda::getInstance()->defaultApp, $request->getApp());
            $this->assertEquals(null, $request->getRequest());
        }

        /**
         * Tests domain with foreign letters
         */
        public function testForeignAppName()
        {
            $_SERVER['REQUEST_URI'] = '/';
            $_SERVER['HTTP_HOST'] = '¢dn.com';

            $request = new Request();
            $this->assertEquals('DnCom', $request->getApp());
            $this->assertEquals(null, $request->getRequest());
        }

        /**
         * Tests what the app name will be if visited by the IP address
         */
        public function testIPAppName()
        {
            $_SERVER['REQUEST_URI'] = '/';
            $_SERVER['HTTP_HOST'] = '94.141.55.60';

            $request = new Request();
            $this->assertEquals(Panda::getInstance()->defaultApp, $request->getApp());
            $this->assertEquals(null, $request->getRequest());
        }

        public function testAppURL()
        {
            $request = new Request('users/bill', 'FacebookCom');
            $this->assertEquals('FacebookCom', $request->getApp());
            $this->assertEquals('users/bill', $request->getRequest());
        }

    }

    