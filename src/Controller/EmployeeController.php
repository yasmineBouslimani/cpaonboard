<?php

namespace App\Controller;

use App\Model\EmployeeManager;
use Symfony\Component\Console\Logger\ConsoleLogger;

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
        /*if ($_SESSION['is_admin'] == "1") {
            header('location:/auth/login');
        }*/

        $employeeManager = new EmployeeManager();

        $employeesCountRequest=$employeeManager->countRecords();
        $employeesCount=$employeesCountRequest[0]['countRecords'];
        $resultsPerPage = 5;
        $pagesCount = ceil($employeesCount / $resultsPerPage);
        $firstResult = ($currentPage * $resultsPerPage) - $resultsPerPage;
        $employees = $employeeManager->selectEmployeesAndContactsData($resultsPerPage, $firstResult);
        $paginationDefaultPagesGap = 2;


        return $this->twig->render('Employee/index.html.twig', ['resultPerPage' => $resultsPerPage, 'employees' => $employees,
            'employeesCount' => $employeesCount, 'pagesCount' => $pagesCount, 'currentPage' => $currentPage,
            'paginationDefaultPagesGap' => $paginationDefaultPagesGap]);
    }

    public function getDataforEmployeeCrud(int $id): string
    {
        /**
         * Display an employee record for edit purpose.
         *
         * @return string
         * @throws \Twig\Error\LoaderError
         * @throws \Twig\Error\RuntimeError
         * @throws \Twig\Error\SyntaxError
         */
        $employeeManager = new EmployeeManager();

        $employee=$employeeManager->selectEmployeeById($id);
        $civilityEnumRequest=$employeeManager->selectCivilityEnum();
        $civilityEnum=$employeeManager->selectCivilityEnum();
        /*$civilityEnumConcat = substr( $civilityEnumRequest['Type'], 5, -1);
        $civilityEnum = explode( "','", $civilityEnumConcat );*/

        return ['employee' => $employee, 'civilityEnum' => $civilityEnum];
    }

    public function show(int $id)
    {
        /**
         * Display an employee record for read purpose only.
         *
         * @return string
         * @throws \Twig\Error\LoaderError
         * @throws \Twig\Error\RuntimeError
         * @throws \Twig\Error\SyntaxError
         */
        /*if ($_SESSION['is_admin'] == "1") {
            header('location:/auth/login');
        }*/

        $employeeManager = new EmployeeManager();

        $employee=$employeeManager->selectEmployeeById($id);
        $civilityEnumRequest=$employeeManager->selectCivilityEnum();
        $civilityEnum=$employeeManager->selectCivilityEnum();
        /*$civilityEnumConcat = substr( $civilityEnumRequest['Type'], 5, -1);
        $civilityEnum = explode( "','", $civilityEnumConcat );*/

//        $data = $this.getDataforEmployeeCrud($id);

        /*return $this->twig->render('Employee/showEmployee.html.twig', ['employee' => $data['employe'],
            'civilityEnum' => $data['civilityEnum'], 'operation' => 'read']);*/
        return $this->twig->render('Employee/showEmployee.html.twig', ['entityRequest' => $employee,
            'civilityEnum' => $civilityEnum, 'operation' => 'read']);
    }

    public function edit(int $id)
    {
        /**
         * Display an employee record for read purpose only.
         *
         * @return string
         * @throws \Twig\Error\LoaderError
         * @throws \Twig\Error\RuntimeError
         * @throws \Twig\Error\SyntaxError
         */
        /*if ($_SESSION['is_admin'] == "1") {
            header('location:/auth/login');
        }*/

        $employeeManager = new EmployeeManager();

        $employee=$employeeManager->selectEmployeeById($id);
        $civilityEnumRequest=$employeeManager->selectCivilityEnum();
        $civilityEnum=$employeeManager->selectCivilityEnum();
        /*$civilityEnumConcat = substr( $civilityEnumRequest['Type'], 5, -1);
        $civilityEnum = explode( "','", $civilityEnumConcat );*/

//        $data = $this.getDataforEmployeeCrud($id);

        /*return $this->twig->render('Employee/showEmployee.html.twig', ['employee' => $data['employe'],
            'civilityEnum' => $data['civilityEnum'], 'operation' => 'read']);*/
        return $this->twig->render('Employee/showEmployee.html.twig', ['employee' => $employee,
            'civilityEnum' => $civilityEnum, 'operation' => 'edit']);
    }

}