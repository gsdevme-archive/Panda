<?php

    namespace Etc\Modules;

interface iCache
    {

        public static function getInstance();

        public function set($key, $value, $time);

        public function get($key);
    }