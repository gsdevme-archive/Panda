<?php
    /**
     * This file is loaded by default within the index.php.
     * 
     * Its main purpose is to provide global functions across all your applications
     * one useful one might be ifsetor() as written below.
     * 
     * It should not be used for a quick fix for adding helping functions !
     * write classes you lazy bastards !
     */
    

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