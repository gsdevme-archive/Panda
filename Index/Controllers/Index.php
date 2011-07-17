<?php

    namespace Controllers;

    class Index extends Controller
    {

        public function index()
        {
            $data = array();
            
            $data['list'] = range(1,10);            
            $this->view('index', $data);

            $this->view('index')->args('test', 'hello does this work ?');
            
            $dataTwo = array();
            $dataTwo['foobar'] = 'Yes this also works';            
            $this->view('index')->args($dataTwo);
            
            $this->render();
            // $this->render(true); sending true caches the view
        }

    }

    