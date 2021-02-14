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

    public function getDataforEmployeeCrud(int $id): array
    {
        /**
         * Display an employee record for edit purpose.
         */
        $employeeManager = new EmployeeManager();
        $employee=$employeeManager->selectEmployeeById($id);
        $civilityEnumRequest=$employeeManager->SelectEnumValues('employee', 'civility');
        $genderEnumRequest=$employeeManager->SelectEnumValues('employee', 'gender');
        $contractTypeEnumRequest=$employeeManager->SelectEnumValues('contract','type_contract');

        $employeeController = new EmployeeController();
        $civilityEnumFormatted = $employeeController->enumRequestFormatting($civilityEnumRequest);
        $civilityEnum=$civilityEnumFormatted['enum'];
        $genderEnumFormatted = $employeeController->enumRequestFormatting($genderEnumRequest);
        $genderEnum=$genderEnumFormatted['enum'];
        $contractTypeEnumFormatted = $employeeController->enumRequestFormatting($contractTypeEnumRequest);
        $contractTypeEnum=$contractTypeEnumFormatted['enum'];

        return ['employee' => $employee, 'civilityEnum' => $civilityEnum, 'genderEnum' => $genderEnum,
            'contractTypeEnum' => $contractTypeEnum];
    }

    public function show(int $id)
    {
        /**
         * Display an employee record for read purpose only.
         */
        /*if ($_SESSION['is_admin'] == "1") {
            header('location:/auth/login');
        }*/


        $employeeController = new EmployeeController();
        $data = $employeeController->getDataforEmployeeCrud($id);

        return $this->twig->render('Employee/showEmployee.html.twig', ['entityRequest' => $data['employee'],
            'civilityEnum' => $data['civilityEnum'], 'genderEnum' => $data['genderEnum'], 'contractTypeEnum' => $data['contractTypeEnum'],
            'operation' => 'read']);
    }

    public function edit(int $id)
    {
        /**
         * Display an employee record for modification purpose.
         */
        /*if ($_SESSION['is_admin'] == "1") {
            header('location:/auth/login');
        }*/

        $employeeController = new EmployeeController();
        $data = $employeeController->getDataforEmployeeCrud($id);

        return $this->twig->render('Employee/showEmployee.html.twig', ['entityRequest' => $data['employee'],
            'civilityEnum' => $data['civilityEnum'], 'genderEnum' => $data['genderEnum'], 'contractTypeEnum' => $data['contractTypeEnum'],
            'operation' => 'edit']);

    }

}