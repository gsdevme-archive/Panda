<?php

    namespace Controllers;

    class Index extends Controller
    {

        public function index()
        {

            // Some basic page Data, perhaps place within your Controller class ?
            $data = array(
                'title' => 'MyAmazingPage',
                'descrption' => 'This test page is amazing !',
                'charset' => 'utf-8'
            );

            // Add our data
            $this->view('index', $data);

            // Lets call a method from our dummy serviceLayer
            $this->view('index')->args('serviceLayer', $this->serviceLayer('Dummy')->doSomething());

            // Lets call a method from our dummy model
            $this->view('index')->args('model', $this->model('Dummy')->doSomething());

            // Lets call a method from our dummy library
            $this->view('index')->args('library', $this->library('Dummy')->doSomething());

            // Lets call a method from a Model which trys a SQL Query
            $this->view('index')->args('dbTest', $this->model('Dummy')->testDbConnection());

            // Lets call a method from our shared dummy model
            $this->view('index')->args('modelShared', $this->model('Share', true)->doSomething());

            // Lets call a method from our shared dummy library
            $this->view('index')->args('libraryShared', $this->library('Share', true)->doSomething());

            $this->library('DummyArgument', false, array(1,2,3,4,5))->test();

            $this->render();
        }

        public function redirect()
        {
            return $this->route('Index', 'Index');
        }

    }

    