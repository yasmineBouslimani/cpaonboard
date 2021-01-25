<?php

namespace App\Model;

class EmployeeModel extends AbstractManager
{
    public const TABLE = 'employee';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
}