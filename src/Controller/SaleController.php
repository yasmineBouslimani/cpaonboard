<?php

namespace App\Controller;

use App\Model\ProfessionalCustomerManager;
use App\Model\IndividualCustomerManager;
use App\Model\SaleManager;
use Symfony\Component\Console\Logger\ConsoleLogger;

class SaleController extends AbstractController
{
    public function index(int $currentPage=1)
    {
        /**
         * Display sales listing
         */
        /*if ($_SESSION['is_admin'] == "1") {
            header('location:/auth/login');
        }*/

        $saleManager = new SaleManager();

        $salesCountRequest=$saleManager->countRecords();
        $salesCount=$salesCountRequest[0]['countRecords'];
        $resultsPerPage = 5;
        $pagesCount = ceil($salesCount / $resultsPerPage);
        $firstResult = ($currentPage * $resultsPerPage) - $resultsPerPage;
        $sales = $saleManager->selectSalesAndAssociatedData($resultsPerPage, $firstResult);
        $paginationDefaultPagesGap = 2;

        return $this->twig->render('sale/index.html.twig', ['resultPerPage' => $resultsPerPage, 'sales' => $sales,
            'salesCount' => $salesCount, 'pagesCount' => $pagesCount, 'currentPage' => $currentPage,
            'paginationDefaultPagesGap' => $paginationDefaultPagesGap]);
    }


    public function getDataforSale(int $id, int $customerType): array
    {
        /**
         * Get in database all data need for displaying a sale record.
         */
        $saleManager = new SaleManager();
        $sale=$saleManager->selectSaleById($id);

        $saleController = new SaleController();
        $saleAllEnumValues = $saleController->getDataEnumforSale($customerType);

        return ['sale' => $sale, 'statusEnum' => $saleAllEnumValues['statusEnum']];
    }

    public function getDataEnumforSale(int $customerType): array
    {
        /**
         * Get in database all enum fields values for displaying a sale record.
         */
        $saleManager = new SaleManager();
        $statusEnumRequest=$saleManager->SelectEnumValues('sale', 'status_sale');
        if ($customerType == 1) {
            $professionalCustomerManager = new ProfessionalCustomerManager();
            $customerRecords=$professionalCustomerManager->selectProfessionalCustomers();
        }
        else{
            $individualCustomerManager = new IndividualCustomerManager();
            $customerRecords=$individualCustomerManager->selectIndividualCustomers();
        }

        $saleController = new SaleController();
        $statusEnumFormatted = $saleController->enumRequestFormatting($statusEnumRequest);
        $statusEnum=$statusEnumFormatted['enum'];
//        $genderEnumFormatted = $employeeController->enumRequestFormatting($genderEnumRequest);
//        $genderEnum=$genderEnumFormatted['enum'];
//        $contractTypeEnumFormatted = $employeeController->enumRequestFormatting($contractTypeEnumRequest);
//        $contractTypeEnum=$contractTypeEnumFormatted['enum'];

        return ['statusEnum' => $statusEnum, 'customerRecords' => $customerRecords];
    }

    public function getFormDataForUpdateOrAdd(array $dataFromForm): array
    {
        /**
         * Get all fields in a sale record form.
         */
        $saleController = new SaleController();
        $allData = [];
        foreach($dataFromForm as $key => $value) {
            //echo "POST parameter '$key' has '$value'";
            $snakeKey = $saleController->camelToSnakeCase($key);
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

    public function showProfessional(int $id)
    {
        /**
         * Display a sale record for read purpose only.
         */
        /*if ($_SESSION['is_admin'] == "1") {
            header('location:/auth/login');
        }*/

        $saleController = new SaleController();
        $data = $saleController->getDataforSale($id, 'Professional');

        return $this->twig->render('sale/show.html.twig', ['sale' => $data['sale'],
            'statusEnum' => $data['statusEnum'], 'customerRecords' => $data['customerRecords'],
            'customerType' => '1', 'operation' => 'show']);
    }

    public function showIndividual(int $id)
    {
        /**
         * Display a sale record for read purpose only.
         */
        /*if ($_SESSION['is_admin'] == "1") {
            header('location:/auth/login');
        }*/


        $saleController = new SaleController();
        $data = $saleController->getDataforSale($id, 2);

        return $this->twig->render('sale/show.html.twig', ['sale' => $data['sale'],
            'statusEnum' => $data['statusEnum'], 'customerRecords' => $data['customerRecords'],
            'customerType' => '2', 'operation' => 'show']);
    }

    public function editProfessional(int $id)
    {
        /**
         * Display a sale record for modification purpose.
         */
        /*if ($_SESSION['is_admin'] == "1") {
            header('location:/auth/login');
        }*/

        $saleController = new SaleController();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $saleManager = new SaleManager();

            $datafromForm = $saleController->getFormDataForUpdateOrAdd($_POST);
            $saleManager->update('employee', $datafromForm['employeeData']);
            $saleManager->update('contact', $datafromForm['contactData']);
            $saleManager->update('contract', $datafromForm['contractData']);
        }

        $data = $saleController->getDataforSale($id, 1);

        return $this->twig->render('sale/show.html.twig', ['sale' => $data['sale'],
            'statusEnum' => $data['statusEnum'], 'customerRecords' => $data['customerRecords'],
            'customerType' => '1', 'operation' => 'edit']);

    }

    public function addProfessional()
    {
        /**
         * Display employee creation page
         *
         * @return string
         * @throws \Twig\Error\LoaderError
         * @throws \Twig\Error\RuntimeError
         * @throws \Twig\Error\SyntaxError
         */

        $saleController = new SaleController();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $saleManager = new SaleManager();

            $datafromForm = $saleController->getFormDataForUpdateOrAdd($_POST);

            $idEmployee = $saleManager->insert('employee', $datafromForm['employeeData']);
            $contactFk = ['fk_id_employee2' => $idEmployee];
            $saleManager->insert('contact', $datafromForm['contactData'], $contactFk);
            $contractFk = ['fk_employee' => $idEmployee];
            $saleManager->insert('contract', $datafromForm['contractData'], $contractFk);

            header('Location:/employee/index');
        }
        else
        {
            $data = $saleController->getDataEnumforSale(1);
        }
        return $this->twig->render('sale/show.html.twig', ['statusEnum' => $data['statusEnum'],
            'customerRecords' => $data['customerRecords'], 'customerType' => '1', 'operation' => 'add']);
    }

    public function addIndividual()
    {
        /**
         * Display employee creation page
         *
         * @return string
         * @throws \Twig\Error\LoaderError
         * @throws \Twig\Error\RuntimeError
         * @throws \Twig\Error\SyntaxError
         */

        $saleController = new SaleController();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $saleManager = new SaleManager();

            $datafromForm = $saleController->getFormDataForUpdateOrAdd($_POST);

            $idEmployee = $saleManager->insert('employee', $datafromForm['employeeData']);
            $contactFk = ['fk_id_employee2' => $idEmployee];
            $saleManager->insert('contact', $datafromForm['contactData'], $contactFk);
            $contractFk = ['fk_employee' => $idEmployee];
            $saleManager->insert('contract', $datafromForm['contractData'], $contractFk);

            header('Location:/employee/index');
        }
        else
        {
            $data = $saleController->getDataEnumforSale(2);
        }
        return $this->twig->render('sale/show.html.twig', ['statusEnum' => $data['statusEnum'],
            'customerRecords' => $data['customerRecords'], 'customerType' => '2', 'operation' => 'add']);
    }

    public function delete(int $id)
    {
        /**
         * Handle employee deletion
         *
         * @param int $id
         */
        $saleManager = new SaleManager();

        $contactId = $saleManager->GetIdRecordsByForeignKeys('contact','fk_id_employee2', $id);
        $contractsId = $saleManager->GetIdRecordsByForeignKeys('contract','fk_employee', $id);

        $saleManager->delete('contact', $contactId[0]['id_contact']);
        foreach($contractsId as $contract) {
            $saleManager->delete('contract', $contract['id_contract']);
        }
        $saleManager->delete('employee', $id);

        header('Location:/employee/index');
    }

    function cancel() {
        return header('Location:/sale/index');
    }

    function camelToSnakeCase($string, $us = "_") {
        return strtolower(preg_replace(
            '/(?<=\d)(?=[A-Za-z])|(?<=[A-Za-z])(?=\d)|(?<=[a-z])(?=[A-Z])/', $us, $string));
    }

}