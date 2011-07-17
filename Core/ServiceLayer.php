<?php

    namespace Core;

    abstract class ServiceLayer
    {

        final protected function model($name, $shared = false)
        {
            return Factory::model($name, $shared);
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

        final protected function view($name, array $args = null, $shared = false)
        {
            return Factory::view($name, $args, $shared);
        }

    }

    