<?php

    namespace ServiceLayers;

    class Users extends ServiceLayer
    {

        public function doSomething()
        {
            $this->model('users')->doSomething();
        }

    }

    