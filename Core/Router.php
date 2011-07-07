<?php

    namespace Core;

    class Router
    {

        /**
         * @param Request $request 
         */
        public static function route(Request $request)
        {
            // Check App
            $app = (is_readable(Panda::getInstance()->sys . $request->getApp()) . '/Config.php') ? $request->getApp() : Panda::getInstance()->defaultApp . '/Config.php';

            //Load Config from App
            
            echo '<pre>App:' . print_r($app, 1) . '</pre>';

            // Check Controller exists 
            // Check Method exists
            // Check any args and does the method take them
        }

    }

    