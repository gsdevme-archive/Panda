<?php

    namespace Controllers;

    class Index extends Controller
    {

        public function index()
        {            
            $this->view('index')->args('serviceLayer', $this->serviceLayer('Dummy')->doSomething());
            
            $this->view('index')->args('library', $this->library('Dummy')->doSomething());
            
            $this->view('index')->args('model', $this->model('Dummy')->doSomething());
            
            $this->view('index')->args('libraryShared', $this->library('Share', true)->doSomething());
            
            $this->view('index')->args('modelShared', $this->model('Share', true)->doSomething());
            
            $this->render();
        }

        public function redirect()
        {
            return $this->route('Index', 'Index');
        }

    }

    