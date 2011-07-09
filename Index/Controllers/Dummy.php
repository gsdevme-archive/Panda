<?php
    namespace Controllers;

    /**
     * This is a dummy class just to show how you secure your 
     * controllers to CLI only, although Controller will work aswell
     * but can be access over HTTP
     */
    class Dummy extends CLIController
    {

        public function index()
        {
            echo '<pre>' . print_r(func_get_args(), 1) . '</pre>';

            echo '<pre>' . print_r(\Core\Panda::getInstance(), 1) . '</pre>';            
        }

    }

?>
