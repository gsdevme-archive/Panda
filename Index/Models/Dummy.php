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
            //try {
                $data = $this->db->query('show databases');

                if (is_array($data)) {
                    $databaseString = null;

                    foreach ($data as $database) {
                        $databaseString .= $database->Database . ', ';
                    }

                    return 'Databases: ' . $databaseString;
                }
            //} catch (\Exception $e) {
                
            //}

            return null;
        }

    }

    