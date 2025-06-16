<?php

namespace Cipika\Component\Database;

class ConnectionManager
{
    public function getConnection()
    {
        $CI =& get_instance();
        $pdo = $CI->db->conn_id;

        $config = new \Doctrine\DBAL\Configuration();
        $connectionParams = [
            'pdo' => $pdo,
        ];

        $dbal = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);

        return $dbal;
    }

    public function createFromCiConfig(array $param)
    {
        $config = new \Doctrine\DBAL\Configuration();
        $pdo = new \PDO($param['hostname'] . ';dbname=' . $param['database'], $param['username'], $param['password']);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $connectionParams = [
            'pdo' => $pdo,
        ];

        $dbal = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);

        return $dbal;
    }
}
