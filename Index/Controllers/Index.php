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
            $this->view('index')->args(array('foobar' => 'yes this also works'));
            
            $this->render();
        }

    }

    