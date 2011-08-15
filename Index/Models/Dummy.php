<?php

    namespace Models;

    /**
     * Dummy class shipped to show an example, you can either edit this or remove it.
     */
    class Dummy extends Model
    {

        public function doSomething()
        {
            return 'Model Dummy called with the method doSomething';
        }

        public function testDbConnection()
        {
            try {
                $this->db->query('SHOW TABLES');
                
                return 'Yeah, you have a database called Test';
            } catch (\Exception $e) {
                
            }
            
            return null;
        }

        public function testSession()
        {
            $this->session->foobar = 'SomeData';
            
            return $this->session->foobar;
        }

    }

    