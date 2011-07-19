<?php

    namespace ServiceLayers;

    /**
     * Dummy class shipped to show an example, you can either edit this or remove it.
     */
    class Dummy extends ServiceLayer
    {

        public function doSomething()
        {
            $libraryReturn = $this->library('Dummy')->doSomething();
            $modelReturn = $this->model('Dummy')->doSomething();
            
            return 'Loaded Dummy Library and Model';
        }

    }

    