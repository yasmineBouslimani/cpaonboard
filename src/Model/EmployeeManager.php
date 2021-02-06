<?php

namespace App\Model;

class EmployeeManager extends AbstractManager
{
    const TABLE = 'employee';

    public function __construct()
    {
        /**
         *  Initializes this class.
         */
        parent::__construct(self::TABLE);
    }


    public function selectEmployeesAndContactsData(int $limit, int $offset): array
    {
        /**
         * Get all row from table employee when criterion are meet.
         *
         * @return array
         */
        return $this->pdo->query('SELECT employee.id_employee, employee.employee_hr_id, employee.active, contact.last_name,
            contact.first_name, employee.department FROM employee
            LEFT JOIN contact ON employee.id_employee = contact.fk_id_employee2
            ORDER BY contact.last_name ASC, contact.first_name ASC
            LIMIT '.$limit.' OFFSET '.$offset.';')->fetchAll();
    }

    public function selectEmployeeById(int $id): array
    {
        /**
         * Get an employee record in database.
         *
         * @return array
         */
        return $this->pdo->query('SELECT * FROM employee
            LEFT JOIN contact ON employee.id_employee = contact.fk_id_employee2
            WHERE id_employee = '.$id.';')->fetchAll();
    }

    public function selectCivilityEnum(): array
    {
        /**
         * Get all civility record in database.
         *
         * @return array
         */
        return $this->pdo->query('SHOW COLUMNS FROM employee LIKE \'civility\';')->fetchAll();
    }



}