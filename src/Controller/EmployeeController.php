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

    public function getDataforEmployee(int $id): array
    {
        /**
         * Display an employee record for edit or show purpose.
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

    /*public function getFormDataForUpdateOrAdd(int $id): array
    {
        /**
         * Display an employee record for edit or show purpose.
         */
        $employeeManager = new EmployeeManager();
        $allData = [];
        foreach($_POST as $key => $value) {
            //echo "POST parameter '$key' has '$value'";
            $snakeKey = $employeeController->camelToSnakeCase($key);
            $allData[$snakeKey] = $_POST[$key];
        }

        $employeeData['id_employee'] = $allData['id_employee'];
        $employeeData['active'] = $allData['active'];
        $employeeData['employee_hr_id'] = $allData['employee_hr_id'];
        $employeeData['gender'] = $allData['gender'];
        $employeeData['civility'] = $allData['civility'];
        $employeeData['birth_date'] = $allData['birth_date'];
        $employeeData['birth_place'] = $allData['birth_place'];
        $employeeData['social_security_number'] = $allData['social_security_number'];
        $employeeData['bank_name'] = $allData['bank_name'];
        $employeeData['bank_city'] = $allData['bank_city'];
        $employeeData['bank_iban'] = $allData['bank_iban'];
        $employeeData['bank_bic'] = $allData['bank_bic'];
        $employeeData['wage_ratio'] = $allData['wage_ratio'];
        $employeeData['wage_hiring'] = $allData['wage_hiring'];
        $employeeData['department'] = $allData['department'];

        return ['employeeData' => $employeeData, 'contactData' => $contactData];*/
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
        $data = $employeeController->getDataforEmployee($id);

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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $employeeManager = new EmployeeManager();
            $allData = [];
            foreach($_POST as $key => $value) {
                //echo "POST parameter '$key' has '$value'";
                $snakeKey = $employeeController->camelToSnakeCase($key);
                $allData[$snakeKey] = $_POST[$key];
            }

            $employeeData['id_employee'] = $allData['id_employee'];
            $employeeData['active'] = $allData['active'];
            $employeeData['employee_hr_id'] = $allData['employee_hr_id'];
            $employeeData['gender'] = $allData['gender'];
            $employeeData['civility'] = $allData['civility'];
            $employeeData['birth_date'] = $allData['birth_date'];
            $employeeData['birth_place'] = $allData['birth_place'];
            $employeeData['social_security_number'] = $allData['social_security_number'];
            $employeeData['bank_name'] = $allData['bank_name'];
            $employeeData['bank_city'] = $allData['bank_city'];
            $employeeData['bank_iban'] = $allData['bank_iban'];
            $employeeData['bank_bic'] = $allData['bank_bic'];
            $employeeData['wage_ratio'] = $allData['wage_ratio'];
            $employeeData['wage_hiring'] = $allData['wage_hiring'];
            $employeeData['department'] = $allData['department'];

            $employeeManager->update('employee', $employeeData);
        }

        $data = $employeeController->getDataforEmployee($id);

        return $this->twig->render('Employee/showEmployee.html.twig', ['entityRequest' => $data['employee'],
            'civilityEnum' => $data['civilityEnum'], 'genderEnum' => $data['genderEnum'],
            'contractTypeEnum' => $data['contractTypeEnum'], 'operation' => 'edit']);

    }

    function camelToSnakeCase($string, $us = "_") {
        return strtolower(preg_replace(
            '/(?<=\d)(?=[A-Za-z])|(?<=[A-Za-z])(?=\d)|(?<=[a-z])(?=[A-Z])/', $us, $string));
    }

}