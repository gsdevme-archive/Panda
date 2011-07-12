<?php

    namespace Controllers;

    class Index extends Controller
    {

        public function index()
        {
            $this->view('index', null, false)->render();
        }

    }

    