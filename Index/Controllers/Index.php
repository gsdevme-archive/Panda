<?php

    namespace Controllers;

    class Index extends Controller
    {

        public function index()
        {
            echo '<pre>' . print_r(func_get_args(), 1) . '</pre>';

            echo '<pre>' . print_r(\Core\Panda::getInstance(), 1) . '</pre>';

            //1 flag means shared, if the param is missing it gets the app model

            $this->model('Users', 1)->doSomething();
            $this->library('Twitter', 1)->doSomething();
            $this->serviceLayer('Users', 1)->doSomething();


            $reg = \Core\Registry::getInstance();
            echo '<pre>' . print_r($reg, 1) . '</pre>';
        }

        public function something()
        {
            echo '<pre>' . print_r(func_get_args(), 1) . '</pre>';

            echo '<pre>' . print_r(\Core\Panda::getInstance(), 1) . '</pre>';
        }

    }

    