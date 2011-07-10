<?php

    namespace Core;

use \Core\Exceptions\Load as LoadException;
use Core\Factory as Factory;

    abstract class Controller
    {

        abstract public function index();

        /**
         * Load a model
         * @param string $name name of the model
         * @param bool $shared is this a shared model?
         * @return object
         */
        final protected function model($name, $shared = false)
        {
            return Factory::model($name,  $shared);
        }
        /**
         * Load a library
         * @param string $name name of the library
         * @param bool $shared is this a shared library?
         * @return object
         */
        final protected function library($name, $shared = false)
        {
            return Factory::library($name, $shared);
        }

        final protected function serviceLayer($name, $shared = false)
        {
            return Factory::serviceLayer($name,$shared);
        }
        final protected function view($name,array $args = null,$shared = false)
        {
            return Factory::view($name,$args,$shared);
        }
    }

    