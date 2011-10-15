<?php

    namespace validations;

    class User extends Validation
    {

        public function username($username)
        {
            return ( bool ) ((!empty($username)) && (preg_match('/(^[A-Z]{1,1}[A-Z0-9_-]{2,20}$)/ui', $username)));
        }

    }