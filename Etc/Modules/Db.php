<?php

    namespace Etc\Modules;

    use \Core\Panda as Panda;
    use Core\Exceptions\ModuleException as ModuleException;
    
    class Db
    {

        private static $_instance;
        private $_db;

        private function __construct()
        {            
            if(isset(Panda::getInstance()->dbClass)){
                $dbClass = '\Etc\Modules\\' . Panda::getInstance()->dbClass;                
                $this->_db = $dbClass::getInstance();
                
                return;
            }
            
            throw new ModuleException('You must define which class to use for the Database within your Config.php for your application, $config->dbClass = \'PDO\';', 500, null);
        }

        public static function getInstance()
        {
            if (!self::$_instance instanceof self) {
                self::$_instance = new self;
            }

            return self::$_instance->getDb();
        }
        
        public function getDb(){
            return $this->_db;
        }

    }

    