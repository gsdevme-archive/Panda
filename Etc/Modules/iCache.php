<?php

    namespace Etc\Modules;

    interface iCache
    {

        public static function getInstance();

        public function set($key, $data, $time);

        public function get($key, $callback=null);
        
        public function delete($key);
        
        public function flush();
    }