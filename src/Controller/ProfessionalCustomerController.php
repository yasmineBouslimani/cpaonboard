<?php

namespace App\Controller;

use App\Model\ProfessionalCustomerManager;

class ProfessionalCustomerController extends AbstractController
{
    public function index(int $currentPage=1)
    {
        /**
         * Display employees listing
         */
        /*if ($_SESSION['is_admin'] == "1") {
            header('location:/auth/login');
        }*/

        $professionalCustomerManager = new ProfessionalCustomerManager();

        $professionalCustomersCountRequest=$professionalCustomerManager->countRecordsProfessionalCustomers();
        $professionalCustomersCount=$professionalCustomersCountRequest[0]['countRecords'];
        $resultsPerPage = 5;
        $pagesCount = ceil($professionalCustomersCount / $resultsPerPage);
        $firstResult = ($currentPage * $resultsPerPage) - $resultsPerPage;
        $professionalCustomers = $professionalCustomerManager->selectProfessionalCustomersData($resultsPerPage, $firstResult);
        $paginationDefaultPagesGap = 2;

        return $this->twig->render('professionalcustomer/index.html.twig', ['resultPerPage' => $resultsPerPage,
            'professionalCustomers' => $professionalCustomers, 'professionalCustomersCount' => $professionalCustomersCount,
            'pagesCount' => $pagesCount, 'currentPage' => $currentPage, 'paginationDefaultPagesGap' => $paginationDefaultPagesGap]);

    }

    public function getDataforProfessionalCustomer(int $id): array
    {
        /**
         * Get in database all data need for displaying an employee record.
         */
        $professionalCustomerManager = new ProfessionalCustomerManager();
        $professionalCustomer=$professionalCustomerManager->selectProfessionalCustomerById($id);

        return ['professionalCustomer' => $professionalCustomer];
    }

    public function getFormDataForUpdateOrAdd(array $dataFromForm): array
    {
        /**
         * Get all fields in an employee record form.
         */
        $professionalCustomerController = new ProfessionalCustomerController();
        $allData = [];
        foreach($dataFromForm as $key => $value) {
            //FORMATTING KEY FOR REQUESTS
            $snakeKey = $professionalCustomerController->camelToSnakeCase($key);
            $allData[$snakeKey] = $_POST[$key];
        }

        $professionalCustomerData['id_customer'] = $allData['id_customer'];
        $professionalCustomerData['FK_customerType'] = 2;

        $contactData['id_contact'] = $allData['id_contact'];
        $contactData['first_name'] = $allData['first_name'];
        $contactData['last_name'] = $allData['last_name'];
        $contactData['corporate_name'] = $allData['corporate_name'];
        $contactData['address_street_number'] = $allData['address_street_number'];
        $contactData['address_street'] = $allData['address_street'];
        $contactData['professional_email_address'] = $allData['professional_email_address'];
        $contactData['cellphone_number'] = $allData['cellphone_number'];
        $contactData['phone_number'] = $allData['phone_number'];
        $contactData['address_city'] = $allData['address_city'];
        $contactData['address_zip_code'] = $allData['address_zip_code'];
        $contactData['address_addition'] = $allData['address_addition'];

        return ['professionalCustomerData' => $professionalCustomerData, 'contactData' => $contactData];

    }

    public function show(int $id)
    {
        /**
         * Display an employee record for read purpose only.
         */
        /*if ($_SESSION['is_admin'] == "1") {
            header('location:/auth/login');
        }*/


        $professionalCustomerController = new ProfessionalCustomerController();
        $data = $professionalCustomerController->getDataforProfessionalCustomer($id);

        return $this->twig->render('professionalcustomer/show.html.twig', ['professionalCustomer' => $data['professionalCustomer'],
            'operation' => 'read']);

    }

    public function edit(int $id)
    {
        /**
         * Display a professional customer record for modification purpose.
         */
        /*if ($_SESSION['is_admin'] == "1") {
            header('location:/auth/login');
        }*/

        $professionalCustomerController = new ProfessionalCustomerController();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $professionalCustomerManager = new ProfessionalCustomerManager();

            $datafromForm = $professionalCustomerController->getFormDataForUpdateOrAdd($_POST);

            $professionalCustomerManager->update('customer', $datafromForm['professionalCustomerData']);
            $professionalCustomerManager->update('contact', $datafromForm['contactData']);

        }

        $data = $professionalCustomerController->getDataforProfessionalCustomer($id);

        return $this->twig->render('professionalcustomer/show.html.twig', ['professionalCustomer' => $data['professionalCustomer'],
            'operation' => 'edit']);

    }

    public function add()
    {
        /**
         * Display a professional customer creation page
         *
         * @return string
         * @throws \Twig\Error\LoaderError
         * @throws \Twig\Error\RuntimeError
         * @throws \Twig\Error\SyntaxError
         */

        $professionalCustomerController = new ProfessionalCustomerController();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $professionalCustomerManager = new ProfessionalCustomerManager();

            $datafromForm = $professionalCustomerController->getFormDataForUpdateOrAdd($_POST);

            $idProfessionalCustomer = $professionalCustomerManager->insert('customer', $datafromForm['professionalCustomerData']);
            $contactFk = ['fk_id_customer2' => $idProfessionalCustomer];
            $professionalCustomerManager->insert('contact', $datafromForm['contactData'], $contactFk);

            header('Location:/professionalcustomer/index');
        }

        return $this->twig->render('professionalCustomer/show.html.twig', ['operation' => 'add']);
    }

    public function delete(int $id)
    {
        /**
         * Handle employee deletion
         *
         * @param int $id
         */
        $professionalCustomerManager = new ProfessionalCustomerManager();

        $contactId = $professionalCustomerManager->GetIdRecordsByForeignKeys('contact','fk_id_customer2', $id);

        $professionalCustomerManager->delete('contact', $contactId[0]['id_contact']);
        $professionalCustomerManager->delete('customer', $id);

        header('Location:/professionalCustomer/index');
    }

    function cancel() {
        return header('Location:/professionalCustomer/index');
    }

    function camelToSnakeCase($string, $us = "_") {
        return strtolower(preg_replace(
            '/(?<=\d)(?=[A-Za-z])|(?<=[A-Za-z])(?=\d)|(?<=[a-z])(?=[A-Z])/', $us, $string));
    }
    
}