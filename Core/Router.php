<?php

    namespace Core;

    class Router
    {

        /**
         * @param Request $request 
         */
        public static function route(Request $request)
        {
            $panda = Panda::getInstance();
            
            // Check App
            $app = (is_readable($panda->sys . $request->getApp() . '/Config.php')) ? $request->getApp() : $panda->defaultApp;

            // Load Apps Settings
            require_once $panda->sys . $app . '/Config.php';
            $panda->import($config);
            $panda->app = $app;
            $panda->sysApp = $panda->sys . $app;

            $request = \SplFixedArray::fromArray(($request->getRequest() !== null) ? explode('/', $request->getRequest()) : array($panda->defaultController, $panda->defaultMethod));
            
            echo '<pre><b>Panda</b> ' . print_r($panda, 1) . '</pre>';
            echo '<pre><b>Request</b> ' . print_r($request, 1) . '</pre>';
            

            // Service Layers ? im confused with the order
            // Check Controller exists 
            // Check Method exists
            // Check any args and does the method take them
        }

    }

    