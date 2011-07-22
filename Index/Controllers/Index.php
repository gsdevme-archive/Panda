<?php

    namespace Controllers;

    class Index extends Controller
    {

        public function index()
        {            
            
            $this->view('index')->args('model', $this->model('Dummy')->doSomething());

            $this->render();
        }

        public function redirect()
        {
            return $this->route('Index', 'Index');
        }

    }

    