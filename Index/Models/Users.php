<?php

namespace Models;

class Users extends \Core\Model
{
    
    public function doSomething()
    {
        echo '<pre>' . print_r('Index/Model doing something - not shared', 1) . '</pre>';
    }
}
