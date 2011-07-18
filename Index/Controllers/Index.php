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
            
            // Cache View
            $this->render(true);
        }
        
        public function redirect(){
            return $this->route('Index', 'Index');
        }

    }

    