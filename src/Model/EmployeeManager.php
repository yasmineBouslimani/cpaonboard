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
        return $this->pdo->query(
            'SELECT employee.id_employee, employee.employee_hr_id, employee.is_active, contact.last_name,
                contact.first_name, employee.fk_department, contract.type_contract, department.label as department,
                employeeFunction.label as employeeFunction
            FROM employee
            LEFT JOIN contact ON employee.id_employee = contact.fk_id_employee2
            LEFT JOIN contract ON employee.id_employee = contract.fk_employee AND contract.on_going = TRUE
            LEFT JOIN department ON employee.fk_department = department.id_department
            LEFT JOIN employeeFunction ON employee.fk_employeefunction = employeeFunction.id_employeeFunction
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
        return $this->pdo->query(
            'SELECT employee.id_employee, contact.id_contact, contract.id_contract, employee.is_active, employee.employee_hr_id,
                employee.gender, employee.civility, contact.last_name, contact.first_name, employee.birth_date,
                employee.birth_place, employee.social_security_number, employee.fk_department, employee.fk_employeeFunction,
                employee.bank_name, employee.bank_city, employee.bank_iban, employee.bank_bic, employee.wage_ratio,
                employee.wage_hiring, contact.address_street_number, contact.address_street, contact.address_addition,
                contact.address_zip_code, contact.address_city, contact.phone_number, contact.cellphone_number,
                contact.personal_email_address, contract.type_contract, contract.starting_date, contract.end_date,
                contract.wage_first_year, contract.wage_second_year, contract.wage_third_year, contract.on_going 
            FROM employee
            LEFT JOIN contact ON employee.id_employee = contact.fk_id_employee2
            LEFT JOIN contract ON employee.id_employee = contract.fk_employee AND contract.on_going = TRUE
            LEFT JOIN department ON employee.fk_department = department.id_department
            LEFT JOIN employeeFunction ON employee.fk_employeeFunction = employeeFunction.id_employeeFunction
            WHERE id_employee = '.$id.';')->fetchAll();
    }

    public function selectDepartments(): array
    {
        /**
         * Get all rows from table Department for departments list.
         *
         * @return array
         */
        return $this->pdo->query(
            'SELECT department.id_department , department.label FROM department
            ORDER BY department.label ASC ;')->fetchAll();
    }

    public function selectFunctions(): array
    {
        /**
         * Get all rows from table Function for functions list.
         *
         * @return array
         */
        return $this->pdo->query(
            'SELECT employeeFunction.id_employeeFunction , employeeFunction.label 
            FROM employeeFunction
            ORDER BY employeeFunction.label ASC ;')->fetchAll();
    }

}