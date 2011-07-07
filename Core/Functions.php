<?php

    /**
     * Function which is "pass by reference" and calls isset() & empty()
     * @param mixed $value
     * @return bool 
     */
    function isValue(&$value)
    {
        return ( bool ) ((isset($value)) && (!empty($value)));
    }

    /**
     * This function adds the purposed language construct detailed here
     * https://wiki.php.net/rfc/ifsetor
     * 
     * @param mixed $value
     * @param mixed $or
     * @return mixed 
     */
    function ifsetor(&$value, $or)
    {
        return (isset($value)) ? $value : $or;
    }

    