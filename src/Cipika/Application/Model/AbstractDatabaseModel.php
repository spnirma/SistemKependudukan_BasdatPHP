<?php

namespace Cipika\Application\Model;

use Doctrine\DBAL\Driver\Connection;

abstract class AbstractDatabaseModel
{
    protected $db;

    public function __construct(Connection $db)
    {   
        $this->db = $db;
    }

    public function getDatabaseConnection()
    {
        return $this->db;
    }
}
