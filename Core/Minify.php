<?php

    namespace Core;

    require_once Panda::getInstance()->thirdParty . 'MinifyHTML.php';

    class Minify{
        private $_minifyHtml;
        
        public function __construct($html){
            $this->_minifyHtml = new \MinifyHTML($html);
        }
        
        public function process(){
            return $this->_minifyHtml->process();
        }
    }
    