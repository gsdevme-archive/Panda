<?php

    namespace Controllers;

    class Index extends Controller
    {

        public function index()
        {
            
            $this->view('dummy',array(
                'message' => 'hello world',
            ))->render();
            
return;
            //1 flag means shared, if the param is missing it gets the app model

           // $this->library('Twitter', 1)->doSomething();
            
            $this->serviceLayer('Users')->doSomething();

            echo '<pre>' . print_r(\Core\Registry::getInstance(), 1) . '</pre>';
        }

        public function something()
        {
            echo '<pre>' . print_r(func_get_args(), 1) . '</pre>';

            echo '<pre>' . print_r(\Core\Panda::getInstance(), 1) . '</pre>';
        }

    }

    