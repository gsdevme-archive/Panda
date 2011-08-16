<?php

    namespace Etc\Modules;

use \Core\Exceptions\ModuleException as ModuleException;

    class APC implements iCache
    {

        public function __construct()
        {
            if (!function_exists('apc_fetch')) {
                throw new ModuleException('Could not find the APC on your system, "apt-get install php5-apc"');
            }
        }

        public function set($key, $data, $time)
        {
            return apc_store(( string ) crc32($key), $data, $time);
        }

        public function get($key, $callback=null)
        {
            $key = crc32($key);
            $data = apc_fetch($key, $bool);

            if ($bool) {
                return $data;
            }

            if ($callback !== null) {
                return call_user_func_array($callback, array($key));
            }

            return null;
        }

        public function delete($key)
        {
            return ( bool ) apc_delete(crc32($key));
        }

        public function flush()
        {
            return ( bool ) apc_clear_cache('user');
        }

    }