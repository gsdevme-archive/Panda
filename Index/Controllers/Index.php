<?php

    namespace Controllers;

    class Index extends Controller
    {

        public function index()
        {
            // Lets call a method from our dummy serviceLayer
            $this->view('index')->args('serviceLayer', $this->serviceLayer('Dummy')->doSomething());

            // Lets call a method from our dummy model
            $this->view('index')->args('model', $this->model('Dummy')->doSomething());

            // Lets call a method from our dummy library
            $this->view('index')->args('library', $this->library('Dummy')->doSomething());

            // Lets call a method from a Model which trys a SQL Query
            $this->view('index')->args('dbTest', $this->model('Dummy')->testDbConnection());

            // Lets call a method from a Model which trys to set some data to a Session
            $this->view('index')->args('sessionTest', $this->model('Dummy')->testSession());

            // Lets call a method from our shared dummy model
            $this->view('index')->args('modelShared', $this->model('Share', true)->doSomething());
            
            // Lets call a method from our shared dummy library
            $this->view('index')->args('libraryShared', $this->library('Share', true)->doSomething());

            $this->render();
        }

        public function redirect()
        {
            return $this->route('Index', 'Index');
        }
        
        public function user($username, $password){
            if($this->validation('User')->username($username)){
                die('Yes valid user');
            }
            
            die('Nope, not a valid user');
        }        

    }

    