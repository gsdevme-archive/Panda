<?php
    $config = new stdClass;

    $config->debug = true;
    $config->defaultController = 'Index';
    $config->defaultMethod = 'Index';
    
    $config->dbClass = 'PDO';
    $config->dbHost = 'mysql:host=127.0.0.1;dbname=test;port=3306';
    $config->dbUser = 'root';
    $config->dbPass = 'rot';
    $config->dbInitCmd = 'SET NAMES \'UTF8\'';
    
    $config->sessionClass = 'Session';