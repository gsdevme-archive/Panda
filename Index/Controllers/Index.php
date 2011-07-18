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

            $arrayOfObjects = array(
                new \stdClass,
                ( object ) array('name' => '<i>bill</i>'),
                ( object ) array('name' => ( object ) array('name' => '<b>bill</b>')),
                ( object ) array('name' => array('<a>bill</a>')),
            );

            $this->view('index')->args('arrayOfObjects', $arrayOfObjects);

            $dataTwo = array();
            $dataTwo['foobar'] = 'Yes this also works';
            $this->view('index')->args($dataTwo);

            $this->render(true);
        }

        public function redirect()
        {
            return $this->route('Index', 'Index');
        }

    }

    