<?php
    $config = new stdClass;

    $config->debug = true;
    $config->defaultController = 'Index';
    $config->defaultMethod = 'Index';
    
    /**
     * Set to false if you wish to manage the instances of 
     * Models, Libraries, ServiceLayers, Helpers 
     * yourself instead of the registry storing them
     */
    $config->appRegistry = true;
    
    $config->dbHost = 'mysql:host=127.0.0.1;port=3306';
    $config->dbUser = 'root';
    $config->dbPass = 'root';
    $config->dbInitCmd = 'SET NAMES \'UTF8\'';
    
    /* To enable sessions to be stored within the Application folder 
    uncomment this line and create a folder /AppName/Sessions */
    //$config->sessionClass = 'SessionHandler';