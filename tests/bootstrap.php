<?php

    spl_autoload_register(function($name)
            {
                $file = './' . str_replace('\\', '/', $name) . '.php';
                if (is_readable($file)) {
                    require_once $file;
                }
            });

    