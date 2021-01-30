<?php

namespace App\Model;

class EmployeeModel extends AbstractManager
{
    const TABLE = 'employee';

    public function __construct()
    {
        /**
         *  Initializes this class.
         */
        parent::__construct(self::TABLE);
    }


    public function selectEmployeesForTable(int $limit, int $offset): array
    {
        /**
         * Get all row from table employee when criterion are meet.
         *
         * @return array
         */
        $test = 'last_name';
        return $this->pdo->query('SELECT employee.id_employee, employee.employee_hr_id, employee.active, contact.last_name,
            contact.first_name, employee.department FROM employee
            LEFT JOIN contact ON employee.id_employee = contact.fk_id_employee2
            ORDER BY contact.last_name ASC, contact.first_name ASC
            LIMIT '.$limit.' OFFSET '.$offset.';')->fetchAll();
    }



}