<?php

    namespace Controllers;

    class Index extends Controller
    {

        public function index()
        {
            $this->model('Users');
        }

    }

    