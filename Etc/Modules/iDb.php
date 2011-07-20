<?php

    namespace Etc\Modules;

interface iDb
    {
        public static function getInstance();

        public function query();
    }