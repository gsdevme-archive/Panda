<?php
    namespace Controllers;

    /**
     * This is a dummy class just to show how you secure your controllers to CLI only, 
     * although Controller will work with CLI if you wish
     */
    class Dummy extends CLIController
    {

        public function index()
        {
            $this->view('dummy');    
        }

    }

?>
