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

    }