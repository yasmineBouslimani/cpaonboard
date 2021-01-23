<?php

class EmployeeModel
{

    function getEmployeesForTable(int $resultsPerPage, int $firstResult)
    {
        //List all employees for display on table.

        require('config/dbConnect.php');
        $db = connectToDb();

        $req = $db->query('SELECT id_employee, active, employee_hr_id, last_name, first_name, department, function FROM employee 
            ORDER BY id_employee LIMIT $firstResult, $resultsPerPage');
        return $req;
    }

    function getEmployee($employeeId)
    {
        //Get data for this employee's record.
        require('config/dbConnect.php');
        $db = connectToDb();

        $req = $db->prepare('SELECT * FROM `employee` WHERE `id_employee` = :idEmployee');
        $req->execute(array(':idEmployee' => $employeeId));
        $employee = $req->fetch();

        return $employee;
    }

}
