<?php

    namespace Core;

    abstract class Controller
    {

        /**
         * Loads/gets a model
         * @param string $name
         * @param bool $shared
         * @return object 
         */
        final protected function model($name, $shared = false)
        {
            return Factory::model($name, $shared);
        }

        /**
         * Loads/gets a library
         * @param string $name
         * @param bool $shared
         * @return object 
         */
        final protected function library($name, $shared = false)
        {
            return Factory::library($name, $shared);
        }

        /**
         * Loads/gets a validation
         * @param string $name
         * @param bool $shared
         * @return object 
         */
        final protected function validation($name, $shared = false)
        {
            return Factory::validation($name);
        }

        /**
         * Loads/gets a service layer
         * @param string $name
         * @param bool $shared
         * @return object 
         */
        final protected function serviceLayer($name, $shared = false)
        {
            return Factory::serviceLayer($name, $shared);
        }

        /**
         * Adds a view to the factory ready for rendering
         * @param string $name
         * @param array $args
         * @param bool $shared
         * @return object 
         */
        final protected function view($name, array $args = null, $shared = false)
        {
            return ViewFactory::getInstance()->addView($name, $args, $shared);
        }

        /**
         * Renders all views
         * @param bool $cache
         * @param bool $xssfilter
         * @return bool 
         */
        final protected function render($cache=false, $xssfilter=true)
        {
            return ViewFactory::getInstance()->render($cache, $xssfilter);
        }

        /**
         * Used to re-route the MVC
         * @param string $controller
         * @param string $method
         * @param array $args
         * @return null 
         */
        final protected function route($controller, $method='index', array $args=null)
        {
            return ControllerFactory::route($controller, $method, $args);
        }

    }

    