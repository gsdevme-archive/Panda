<?php
    $config = new stdClass;

    $config->debug = true;
    $config->defaultController = 'Index';
    $config->defaultMethod = 'Index';
    
    $config->dbHost = 'mysql:host=127.0.0.1;dbname=test;port=3306';
    $config->dbUser = 'root';
    $config->dbPass = 'root';
    $config->dbInitCmd = 'SET NAMES \'UTF8\'';
    
    /* To enable sessions to be stored within the Application folder 
    uncomment this line and create a folder /AppName/Sessions */
    //$config->sessionClass = 'SessionHandler';