<?php

    namespace Modules;

    interface iCache
    {
        public function set($key, $data, $time);

        public function get($key, $callback=null, array $args=null);
        
        public function delete($key);
        
        public function flush();
    }