<?php

    namespace Controllers;

    class Index extends Controller
    {

        public function index()
        {            
            $this->view('index')->args('model', $this->model('Dummy')->doSomething());
            
            $this->view('index')->args('library', $this->library('Dummy')->doSomething());
            
            $this->view('index')->args('dbTest', $this->model('Dummy')->testDbConnection());

            $this->render();
        }

        public function redirect()
        {
            return $this->route('Index', 'Index');
        }

    }

    