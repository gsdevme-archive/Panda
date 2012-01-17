<?php

    namespace System\Panda;

    use \System\ViewFactory as ViewFactory;

    abstract class Controller
    {

        /**
         * Loads/gets a model
         * @param string $name
         * @param bool $shared
         * @return object 
         */
        protected function model($name, $shared = false)
        {
            return Factory::model($name, $shared);
        }

        /**
         * Loads/gets a library
         * @param string $name
         * @param bool $shared
         * @param array arguments for the library
         * @return object 
         */
        protected function library($name, $shared = false, array $arguments=null)
        {
            return Factory::library($name, $shared, $arguments);
        }

        /**
         * Loads/gets a service layer
         * @param string $name
         * @param bool $shared
         * @return object 
         */
        protected function serviceLayer($name, $shared = false)
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
        protected function view($name, array $args = null, $shared = false)
        {
            return ViewFactory::getInstance()->addView($name, $args, $shared);
        }

        /**
         * Renders all views
         * @param bool $cache
         * @param bool $xssfilter
         * @return bool 
         */
        protected function render($cache=false, $xssfilter=true, array $headers=null)
        {
            return ViewFactory::getInstance()->render($cache, $xssfilter, $headers);
        }

        /**
         * Used to re-route the MVC
         * @param string $controller
         * @param string $method
         * @param array $args
         * @return null 
         */
        protected function route($controller, $method='index', array $args=null)
        {
            return ControllerFactory::route($controller, $method, $args);
        }

    }

    