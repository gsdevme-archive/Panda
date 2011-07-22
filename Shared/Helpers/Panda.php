<?php

    namespace Helpers;

    class Panda
    {

        public function ifsetor(&$value, $or=null)
        {
            return (isset($value)) ? $value : $or;
        }

    }

    