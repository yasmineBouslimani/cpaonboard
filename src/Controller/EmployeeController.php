<?php

namespace App\Controller;

use App\Model\EmployeeModel;

class EmployeeController extends AbstractController
{
    public function index(int $currentPage=1)
    {
        /**
         * Display employees listing
         *
         * @return string
         * @throws \Twig\Error\LoaderError
         * @throws \Twig\Error\RuntimeError
         * @throws \Twig\Error\SyntaxError
         */

        $employeeModel = new EmployeeModel();

        $employeesCountRequest=$employeeModel->countRecords();
        $employeesCount=$employeesCountRequest[0]['countRecords'];
        $resultsPerPage = 5;
        $pagesCount = ceil($employeesCount / $resultsPerPage);
        $firstResult = ($currentPage * $resultsPerPage) - $resultsPerPage;
        $employees = $employeeModel->selectEmployeesForTable($resultsPerPage, $firstResult);
        $paginationDefaultPagesGap = 2;

        return $this->twig->render('Employee/index.html.twig', ['resultPerPage' => $resultsPerPage, 'employees' => $employees,
            'employeesCount' => $employeesCount, 'pagesCount' => $pagesCount, 'currentPage' => $currentPage,
            'paginationDefaultPagesGap' => $paginationDefaultPagesGap]);
    }

    public function show(int $id)
    {
        /**
         * Display an employee record.
         *
         * @return string
         * @throws \Twig\Error\LoaderError
         * @throws \Twig\Error\RuntimeError
         * @throws \Twig\Error\SyntaxError
         */

        $employeeModel = new EmployeeModel();
        $id_name = 'id_employee';
        $employee=$employeeModel->selectOneById($id_name, $id);

        return $this->twig->render('Employee/showEmployee.html.twig', ['employee' => $employee]);
    }

}