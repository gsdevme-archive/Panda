<?php

    namespace Core;

    class Router
    {

        /**
         * 
         * @param Request $request 
         */
        public static function route(Request $request)
        {
            echo '<pre>' . print_r($request, 1) . '</pre>';
        }

    }

    