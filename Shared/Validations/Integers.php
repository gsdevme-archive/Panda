<?php

    namespace validations;

    /**
     * Validation class for handling data types used within the popular database server MYSQL
     */
    class Integers extends Validation
    {

        /**
         * Allows $this->validation('integers')->isTinyInt($var1, $var2, $var3);
         * 
         * @param string $method
         * @param type $args
         * @return type 
         */
        public function __call($method, $args)
        {
            $method = '_' . $method;
            foreach (( array ) $args as $value) {
                if (!$this->$method($value)) {
                    return ( bool ) false;
                }
            }

            return ( bool ) true;
        }

        private function _isTinyInt($value)
        {
            return ( bool ) (($value >= -128) && ($value <= 127));
        }

        private function _isUTinyInt($value)
        {
            return ( bool ) (($value >= 0) && ($value <= 255));
        }

        private function _isSmallInt($value)
        {
            return ( bool ) (($value >= -32768) && ($value <= 32767));
        }

        private function _isUSmallInt($value)
        {
            return ( bool ) (($value >= 0) && ($value <= 65535));
        }

        private function _isMediumInt($value)
        {
            return ( bool ) (($value >= 8388608) && ($value <= 8388607));
        }

        private function _isUMediumInt($value)
        {
            return ( bool ) (($value >= 0) && ($value <= 16777215));
        }

        private function _isInt($value)
        {
            return ( bool ) (($value >= -2147483648) && ($value <= 2147483647));
        }

        private function _isUInt($value)
        {
            return ( bool ) (($value >= 0) && ($value <= 4294967295));
        }

        /**
         * PLEASE NOTE: if you wish to print this kind of number use, echo sprintf('%0.0f', $myNumber);
         */
        private function _isBigInt($value)
        {
            return ( bool ) (($value >= -9223372036854775808) && ($value <= 9223372036854775807));
        }

        /**
         * PLEASE NOTE: my understanding is that PHP cannot handle this kind of number its impossible for it to be printed even within sprintf()
         */
        private function _isUBigInt($value)
        {
            return ( bool ) (($value >= 0) && ($value <= 18446744073709551615));
        }

    }