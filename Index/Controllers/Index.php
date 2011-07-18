<?php

    namespace Controllers;

    class Index extends Controller
    {

        public function index()
        {
            $data = array();
            
            $data['list'] = array(
                '<script>document.write("worked");</script>',
                '<script>document.write("worked");</script>',
                '<script>document.write("worked");</script>',
                '<script>document.write("worked");</script>',
                '<script>document.write("worked");</script>',
            );            
            $this->view('index', $data);

            $this->view('index')->args('test', 'hello does this work ?');
            
            $dataTwo = array();
            $dataTwo['foobar'] = 'Yes this also works';            
            $this->view('index')->args($dataTwo);
            
            $this->render();
            // $this->render(); sending within true will make the view NOT cache
        }

    }

    