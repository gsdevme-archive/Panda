<?php

    namespace System\Components;

    interface iDb
    {
        public static function getInstance();

        public function query();
    }