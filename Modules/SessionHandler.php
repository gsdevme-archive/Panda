<?php

    namespace Modules;

use \GlobIterator;
use \SplFileObject;
use \SplFileInfo;
use \RuntimeException;
use \Exception;
use \Core\Panda\Panda;

    class SessionHandler
    {

        private $_sessionPath;

        /**
         * This method is used set the session path into the object
         * @return <void>
         */
        public function __construct()
        {
            $this->_sessionPath = Panda::getInstance()->appRoot . 'sessions/';
        }

        /**
         * This method is used to read the session data
         * @param <string> $id
         * @return <string>
         */
        public function read($id)
        {
            $return = null;

            try {
                $file = new SplFileObject($this->_sessionPath . hash('md4', $id) . '.session', 'r');
                $return = ( string ) $file->fgets();
            } catch (\RuntimeException $e) {
                //ignore
            }

            return ( string ) $return;
        }

        /**
         * This method is used to writethe session data
         * @author Gavin Staniforth
         * @access public
         * @param <string> $id
         * @param <string> $data
         * @return <string>
         * @since 1.0
         */
        public function write($id, $data)
        {
            try {
                if (strlen($data) > 0) {
                    $file = new SplFileObject($this->_sessionPath . hash('md4', $id) . '.session', 'w');
                    $file->fwrite($data);
                }

                return ( bool ) true;
            } catch (RuntimeException $e) {
                error_log('Failed to write session, this could be a permissions issue, ' . $e->getMessage());
            }

            return ( bool ) false;
        }

        /**
         * This method is called as a destructor for this purpose isn't needed.
         * @author Gavin Staniforth
         * @access public
         * @return <bool>
         * @since 1.0
         */
        public function close()
        {
            return ( bool ) true;
        }

        /**
         * This method is key to maintaining the folder and cleaning up any old sessions
         * its called based on values of session.gc_probability and session.gc_divisor for performance you can increase them
         * @author Gavin Staniforth
         * @access public
         * @return <bool>
         * @since 1.0
         */
        public function gc($life)
        {
            foreach (new GlobIterator($this->_sessionPath . '*.session') as $session) {
                try {
                    $session = new SplFileInfo($session);

                    if ($session->getCTime() + $life < time()) {
                        unlink($session->getPathname());
                    }
                } catch (Exception $e) {
                    error_log($e->getMessage());
                }
            }

            return ( bool ) true;
        }

        /**
         * This method is called when the session is deleted
         * @return <bool>
         */
        public function destroy($id)
        {
            $file = $this->_sessionPath . hash('md4', $id) . '.session';

            if (is_file($file)) {
                unlink($file);
                return ( bool ) true;
            }

            return ( bool ) false;
        }

        /**
         * This isnt used
         */
        public function open($path, $id)
        {
            return ( bool ) true;
        }

    }

    