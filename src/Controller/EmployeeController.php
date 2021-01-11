<?php


namespace App\Controller;

use EmployeeModel;

class EmployeeController extends AbstractController
{

    public function show()
    {
        $employeeModel = new EmployeeModel();
        $employees = $employeeModel->getEmployeesForTable();
        return $this->twig->render('Employee/show.html.twig', [
            'employees'=>$employees]);
    }

}