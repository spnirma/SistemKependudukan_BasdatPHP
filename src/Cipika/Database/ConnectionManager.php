<?php

namespace Cipika\Database;

class ConnectionManager
{
    private static $connections = array();

    private static $readDb;

    public static function get($name)
    {
        if (!isset(self::$connections[$name])) {
            $CI = get_instance();
            self::$connections[$name] = $CI->load->database($name, true);
            self::$connections[$name]->initialize();
        }

        return self::$connections[$name];
    }

    public static function getReadDb()
    {
        if (null === self::$readDb) {
            $CI = get_instance();
            if ( ! defined('ENVIRONMENT') OR ! file_exists($file_path = APPPATH.'config/'.ENVIRONMENT.'/database.php')) {
                if ( ! file_exists($file_path = APPPATH.'config/database.php')) {
                    show_error('The configuration file database.php does not exist.');
                }
            }

            include($file_path);

            if (count($db) <= 1) {
                self::$readDb = $CI->db;
            } else {
                $dbGroupNames = $db;
                if (isset($dbGroupNames['default'])) {
                    unset($dbGroupNames['default']);
                }

                $dbGroupNames = array_keys($dbGroupNames);
                $randomDb = $dbGroupNames[mt_rand(0, count($dbGroupNames) - 1)];

                self::$readDb = self::get($randomDb);
            }
        }

        return self::$readDb;
    }
}
