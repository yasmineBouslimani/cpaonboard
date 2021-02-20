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
         * Get in database all data need for displaying an employee record.
         */
        $employeeManager = new EmployeeManager();
        $employee=$employeeManager->selectEmployeeById($id);

        $employeeController = new EmployeeController();
        $employeeAllEnumValues = $employeeController->getDataEnumforEmployee();

        return ['employee' => $employee, 'civilityEnum' => $employeeAllEnumValues['civilityEnum'],
            'genderEnum' => $employeeAllEnumValues['genderEnum'],
            'contractTypeEnum' => $employeeAllEnumValues['contractTypeEnum']];
    }

    public function getDataEnumforEmployee(): array
    {
        /**
         * Get in database all enum fields values for displaying an employee record.
         */
        $employeeManager = new EmployeeManager();
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

        return ['civilityEnum' => $civilityEnum, 'genderEnum' => $genderEnum,
            'contractTypeEnum' => $contractTypeEnum];
    }

    public function getFormDataForUpdateOrAdd(array $dataFromForm): array
    {
        /**
         * Get all fields in an employee record form.
         */
        $employeeController= new EmployeeController();
        $allData = [];
        foreach($dataFromForm as $key => $value) {
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

        $contactData['id_contact'] = $allData['id_contact'];
        $contactData['first_name'] = $allData['first_name'];
        $contactData['last_name'] = $allData['last_name'];
        $contactData['address_street_number'] = $allData['address_street_number'];
        $contactData['address_street'] = $allData['address_street'];
        $contactData['personal_email_address'] = $allData['personal_email_address'];
        $contactData['cellphone_number'] = $allData['cellphone_number'];
        $contactData['phone_number'] = $allData['phone_number'];
        $contactData['address_city'] = $allData['address_city'];
        $contactData['address_zip_code'] = $allData['address_zip_code'];
        $contactData['address_addition'] = $allData['address_addition'];

        $contractData['id_contract'] = $allData['id_contract'];
        $contractData['type_contract'] = $allData['type_contract'];
        $contractData['starting_date'] = $allData['starting_date'];
        $contractData['end_date'] = $allData['end_date'];
        $contractData['wage_first_year'] = $allData['wage_first_year'];
        $contractData['wage_second_year'] = $allData['wage_second_year'];
        $contractData['wage_third_year'] = $allData['wage_third_year'];
        $contractData['on_going'] = $allData['on_going'] ? 1 : 0;

        return ['employeeData' => $employeeData, 'contactData' => $contactData, 'contractData' => $contractData];

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

            $datafromForm = $employeeController->getFormDataForUpdateOrAdd($_POST);
            $employeeManager->update('employee', $datafromForm['employeeData']);
            $employeeManager->update('contact', $datafromForm['contactData']);
            $employeeManager->update('contract', $datafromForm['contractData']);
        }

        $data = $employeeController->getDataforEmployee($id);

        return $this->twig->render('Employee/showEmployee.html.twig', ['entityRequest' => $data['employee'],
            'civilityEnum' => $data['civilityEnum'], 'genderEnum' => $data['genderEnum'],
            'contractTypeEnum' => $data['contractTypeEnum'], 'operation' => 'edit']);

    }

    public function add()
    {
        /**
         * Display employee creation page
         *
         * @return string
         * @throws \Twig\Error\LoaderError
         * @throws \Twig\Error\RuntimeError
         * @throws \Twig\Error\SyntaxError
         */

        $employeeController = new EmployeeController();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $employeeManager = new EmployeeManager();

            $datafromForm = $employeeController->getFormDataForUpdateOrAdd($_POST);
            $idEmployee = $employeeManager->insert('employee', $datafromForm['employeeData']);
            $contactFk = ['fk_id_employee2' => $idEmployee];
            $employeeManager->insert('contact', $datafromForm['contactData'], $contactFk);
            $contractFk = ['fk_employee' => $idEmployee];
            $employeeManager->insert('contract', $datafromForm['contractData'], $contractFk);

            $data = $employeeController->getDataforEmployee($idEmployee);
        }
        else
        {
            $data = $employeeController->getDataEnumforEmployee();
        }

        return $this->twig->render('Employee/showEmployee.html.twig', [
            'civilityEnum' => $data['civilityEnum'], 'genderEnum' => $data['genderEnum'],
            'contractTypeEnum' => $data['contractTypeEnum'], 'operation' => 'add']);
    }

    function camelToSnakeCase($string, $us = "_") {
        return strtolower(preg_replace(
            '/(?<=\d)(?=[A-Za-z])|(?<=[A-Za-z])(?=\d)|(?<=[a-z])(?=[A-Z])/', $us, $string));
    }

}