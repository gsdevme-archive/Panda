<?php

    namespace Etc\Modules;

use \PDOException as PDOException;
use \PDO as PDO;
use \Core\Panda as Panda;
use \Core\Exceptions\ModuleException as ModuleException;
use \SplFixedArray as SplFixedArray;

    class Db implements iDb
    {

        private static $_instance;
        private $_pdo;

        private function __construct()
        {
            $panda = Panda::getInstance();

            if (isset($panda->dbHost, $panda->dbUser, $panda->dbPass)) {
                try {
                    if(isset($panda->dbInitCmd)){
                        $this->_pdo = new PDO($panda->dbHost, $panda->dbUser, $panda->dbPass, array(PDO::MYSQL_ATTR_INIT_COMMAND => $panda->dbInitCmd));
                    }else{
                        $this->_pdo = new PDO($panda->dbHost, $panda->dbUser, $panda->dbPass);
                    }
                    
                    $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    return;
                } catch (PDOException $e) {
                    throw new ModuleException('Failed to connect to your database', 500, $e);
                }
            }

            throw new ModuleException('You must define a dbHost, dbUser, dbPass and DbinitCmd within your config', 500, null);
        }

        public static function getInstance()
        {
            if (!self::$_instance instanceof self) {
                self::$_instance = new self;
            }

            return self::$_instance;
        }

        public function query()
        {
            $args = SplFixedArray::fromArray(func_get_args());

            if ($args->count() !== 0) {
                $query = $args->current();
                $args->next();

                try {
                    $return = ( bool ) !preg_match('/(^INSERT|^DELETE|^UPDATE)/i', $query);
                    $stmt = $this->_pdo->prepare($query);

                    if ($args->count() !== 0) {
                        for ($args; $args->valid(); $args->next()) {
                            $value = $args->current();
                            $data = $this->_dataType($value);

                            $stmt->bindValue($args->key(), $data->value, $data->type);
                        }
                    }

                    if ($stmt->execute()) {
                        if ($return === true) {
                            $data = $stmt->fetchAll(PDO::FETCH_CLASS);

                            if (!empty($data)) {
                                return ( array ) $data;
                            }

                            return null;
                        }

                        if (preg_match('/^INSERT/i', $query)) {
                            return ( int ) $this->lastInsertId();
                        }

                        return ( int ) $stmt->rowCount();
                    }

                    throw new ModuleException('Query failed, Query: ' . $stmt->queryString, 500, $e);
                } catch (PDOException $e) {
                    switch($e->getCode()){
                        // This is a Integrity constraint violation, so we return false
                        case '23000':
                            return ( bool ) false;
                            
                        // No data, could be from a SP                           
                        case '02000':
                            return null;
                    }

                    throw new ModuleException('Looks like your query syntax is wrong, Query: ' . $query, 500, $e);
                }
            }

            throw new ModuleException('No arguments given to query()', 500, null);
        }

        /**
         * returns last insert id
         * @return type 
         */
        public function lastInsertId()
        {
            return $this->_pdo->lastInsertId();
        }

        /**
         * Start transaction
         * @return bool 
         */
        public function beginTransaction()
        {
            return ( bool ) $this->_pdo->beginTransaction();
        }

        /**
         * Rolls back the DB
         * @return bool 
         */
        public function rollBack()
        {
            return ( bool ) $this->_pdo->rollBack();
        }

        /**
         * Commits the DB
         * @return bool
         */
        public function commit()
        {
            return ( bool ) $this->_pdo->commit();
        }

        /**
         * returns bool depending of the transaction state
         * @return bool 
         */
        public function inTransaction()
        {
            return ( bool ) $this->_pdo->inTransaction();
        }

        /**
         * Returns ErrorInfo
         * @return mixed 
         */
        public function errorInfo()
        {
            return $this->_pdo->errorInfo();
        }

        /**
         * Returns ErrorCode
         * @return mixed
         */
        public function errorCode()
        {
            return $this->_pdo->errorCode();
        }

        /**
         * Returns setAttribute
         * @return mixed 
         */
        public function setAttribute()
        {
            return call_user_func_array(array($this->_pdo, 'setAttribute'), func_get_args());
        }

        /**
         * Returns the data type
         * @param type $value
         * @return type 
         */
        private function _dataType(&$value)
        {
            switch (true) {
                case is_null($value):
                    return ( object ) array('value' => null, 'type' => \PDO::PARAM_NULL);
                case is_int($value):
                    return ( object ) array('value' => ( int ) $value, 'type' => \PDO::PARAM_INT);
                case is_bool($value):
                    return ( object ) array('value' => ( bool ) $value, 'type' => \PDO::PARAM_BOOL);
                default:
                    return ( object ) array('value' => ( string ) $value, 'type' => \PDO::PARAM_STR);
            }
        }

    }

    