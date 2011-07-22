<?php
    $config = new stdClass;

    $config->debug = true;
    $config->defaultController = 'Index';
    $config->defaultMethod = 'Index';
    
    $config->dbClass = 'PDO';
    
    $config->sessionClass = 'Session';