<?php

namespace App\Controller;

use App\Model\EmployeeManager;
use App\Model\IndividualCustomerManager;
use Symfony\Component\Console\Logger\ConsoleLogger;

class IndividualCustomerController extends AbstractController
{
    public function index(int $currentPage=1)
    {
        /**
         * Display employees listing
         */
        /*if ($_SESSION['is_admin'] == "1") {
            header('location:/auth/login');
        }*/

        $individualCustomerManager = new IndividualCustomerManager();

        $individualCustomersCountRequest=$individualCustomerManager->countRecordsIndividualCustomers();
        $individualCustomersCount=$individualCustomersCountRequest[0]['countRecords'];
        $resultsPerPage = 5;
        $pagesCount = ceil($individualCustomersCount / $resultsPerPage);
        $firstResult = ($currentPage * $resultsPerPage) - $resultsPerPage;
        $individualCustomers = $individualCustomerManager->selectIndividualCustomersData($resultsPerPage, $firstResult);
        $paginationDefaultPagesGap = 2;

        return $this->twig->render('IndividualCustomer/index.html.twig', ['resultPerPage' => $resultsPerPage,
            'individualCustomers' => $individualCustomers, 'individualCustomersCount' => $individualCustomersCount,
            'pagesCount' => $pagesCount, 'currentPage' => $currentPage, 'paginationDefaultPagesGap' => $paginationDefaultPagesGap]);

    }

    public function getDataforIndividualCustomer(int $id): array
    {
        /**
         * Get in database all data need for displaying an employee record.
         */
        $individualCustomerManager = new IndividualCustomerManager();
        $individualCustomer=$individualCustomerManager->selectIndividualCustomerById($id);
        $vehicules=$individualCustomerManager->selectVehiculesByCustomerId($id);

        return ['individualCustomer' => $individualCustomer, 'vehicules' => $vehicules];
    }

    /*public function getDataEnumforEmployee(): array
    {*/
        /**
         * Get in database all enum fields values for displaying an employee record.
         */
    /* $employeeManager = new EmployeeManager();
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
 }*/

    public function getFormDataForUpdateOrAdd(array $dataFromForm): array
    {
        /**
         * Get all fields in an employee record form.
         */
        $individualCustomerController = new IndividualCustomerController();
        $allData = [];
        foreach($dataFromForm as $key => $value) {
            //echo "POST parameter '$key' has '$value'";
            $snakeKey = $individualCustomerController->camelToSnakeCase($key);
            $allData[$snakeKey] = $_POST[$key];
        }

        $individualCustomerData['id_customer'] = $allData['id_customer'];
        $individualCustomerData['FK_customerType'] = 1;

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

        return ['individualCustomerData' => $individualCustomerData, 'contactData' => $contactData];

    }

    public function show(int $id)
    {
        /**
         * Display an employee record for read purpose only.
         */
        /*if ($_SESSION['is_admin'] == "1") {
            header('location:/auth/login');
        }*/


        $individualCustomerController = new IndividualCustomerController();
        $data = $individualCustomerController->getDataforIndividualCustomer($id);

        return $this->twig->render('individualCustomer/show.html.twig', ['individualCustomer' => $data['individualCustomer'],
            'vehicules' => $data['vehicules'], 'operation' => 'read']);
    }

    public function edit(int $id)
    {
        /**
         * Display an employee record for modification purpose.
         */
        /*if ($_SESSION['is_admin'] == "1") {
            header('location:/auth/login');
        }*/

        $individualCustomerController = new IndividualCustomerController();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $individualCustomerManager = new IndividualCustomerManager();

            $datafromForm = $individualCustomerController->getFormDataForUpdateOrAdd($_POST);
            $individualCustomerManager->update('customer', $datafromForm['individualCustomerData']);
            $individualCustomerManager->update('contact', $datafromForm['contactData']);
        }

        $data = $individualCustomerController->getDataforIndividualCustomer($id);

        return $this->twig->render('individualCustomer/show.html.twig', ['individualCustomer' => $data['individualCustomer'],
            'vehicules' => $data['vehicules'], 'operation' => 'edit']);

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

        $individualCustomerController = new IndividualCustomerController();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $individualCustomerManager = new IndividualCustomerManager();

            $datafromForm = $individualCustomerController->getFormDataForUpdateOrAdd($_POST);
            $idIndividualCustomer = $individualCustomerManager->insert('customer', $datafromForm['individualCustomerData']);
            $contactFk = ['fk_id_customer2' => $idIndividualCustomer];
            $individualCustomerManager->insert('contact', $datafromForm['contactData'], $contactFk);

            header('Location:/individualCustomer/index');
        }

        return $this->twig->render('individualCustomer/show.html.twig', ['operation' => 'add']);
    }

    public function delete(int $id)
    {
        /**
         * Handle employee deletion
         *
         * @param int $id
         */
        $individualCustomerManager = new IndividualCustomerManager();

        $contactId = $individualCustomerManager->GetIdRecordsByForeignKeys('contact','fk_id_customer2', $id);

        $individualCustomerManager->delete('contact', $contactId[0]['id_contact']);
        $individualCustomerManager->delete('customer', $id);

        header('Location:/individualCustomer/index');
    }

    function camelToSnakeCase($string, $us = "_") {
        return strtolower(preg_replace(
            '/(?<=\d)(?=[A-Za-z])|(?<=[A-Za-z])(?=\d)|(?<=[a-z])(?=[A-Z])/', $us, $string));
    }

}