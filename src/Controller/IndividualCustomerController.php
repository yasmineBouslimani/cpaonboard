<?php

namespace App\Controller;

use App\Model\IndividualCustomerManager;

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
        $vehicles=$individualCustomerManager->selectVehiclesByCustomerId($id);

        $individualCustomerController = new IndividualCustomerController();
        $individualCustomerAllEnumValues = $individualCustomerController->getDataEnumforIndividualCustomer();

        return ['individualCustomer' => $individualCustomer, 'vehicles' => $vehicles,
            'energyTypeEnum' => $individualCustomerAllEnumValues['energyTypeEnum'],
            'gearBoxTypeEnum' => $individualCustomerAllEnumValues['gearBoxTypeEnum']];
    }

    function getDataEnumforIndividualCustomer(): array
    {
        /**
         * Get in database all enum fields values for displaying an individual customer record.
         */
        $individualCustomerManager = new IndividualCustomerManager();
        $energyTypeEnumRequest=$individualCustomerManager->SelectEnumValues('vehicle', 'energy_type');
        $gearBoxTypeEnumRequest=$individualCustomerManager->SelectEnumValues('vehicle', 'gear_box_type');

        $employeeController = new EmployeeController();
        $energyTypeEnumFormatted = $employeeController->enumRequestFormatting($energyTypeEnumRequest);
        $energyTypeEnum=$energyTypeEnumFormatted['enum'];
        $gearBoxTypeEnumFormatted = $employeeController->enumRequestFormatting($gearBoxTypeEnumRequest);
        $gearBoxTypeEnum=$gearBoxTypeEnumFormatted['enum'];

        return ['energyTypeEnum' => $energyTypeEnum, 'gearBoxTypeEnum' => $gearBoxTypeEnum];
    }

    public function getFormDataForUpdateOrAdd(array $dataFromForm): array
    {
        /**
         * Get all fields in an employee record form.
         */
        $individualCustomerController = new IndividualCustomerController();
        $allData = [];
        $vehicleFormFields=['id_vehicle', 'manufacture_year', 'license_plate', 'fiscal_horse_power', 'door_number', 'energy_type',
            'gear_box_type', 'fk_vehicleModel'];
        $vehicleModelFormFields=['id_vehicleModel', 'model', 'make'];
        $vehiclesData = [];
        foreach($dataFromForm as $key => $value) {
            //FORMATTING KEY FOR REQUESTS
            $snakeKey = $individualCustomerController->camelToSnakeCase($key);
            $allData[$snakeKey] = $_POST[$key];

            //BUILD VEHICLES ARRAY
            $fieldLabel  = substr("$snakeKey", 0,-2);
            $fieldIndex = substr("$snakeKey", -1,1);
            if (in_array($fieldLabel, $vehicleFormFields )){
                $vehiclesData[$fieldIndex]['vehicleData'][$fieldLabel] = $allData[$snakeKey];
            }
            if (in_array($fieldLabel, $vehicleModelFormFields )){
                $vehiclesData[$fieldIndex]['vehicleModelData'][$fieldLabel] = $allData[$snakeKey];
            }
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

        return ['individualCustomerData' => $individualCustomerData, 'contactData' => $contactData, 'vehiclesData' => $vehiclesData];

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
            'vehicles' => $data['vehicles'], 'energyTypeEnum' => $data['energyTypeEnum'], 'gearBoxTypeEnum' => $data['gearBoxTypeEnum'],
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

        $individualCustomerController = new IndividualCustomerController();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $individualCustomerManager = new IndividualCustomerManager();

            $datafromForm = $individualCustomerController->getFormDataForUpdateOrAdd($_POST);

            $individualCustomerManager->update('customer', $datafromForm['individualCustomerData']);
            $individualCustomerManager->update('contact', $datafromForm['contactData']);

            if (!$datafromForm['vehiclesData']){
                exit;
            }
            foreach($datafromForm['vehiclesData'] as $vehicle) {
                if ($vehicle['vehicleData']['id_vehicle']) {
                    /*$individualCustomerManager->update('vehicle', $vehicle['vehicleData']);
                    $individualCustomerManager->update('vehiclemodel', $vehicle['vehicleData']);*/
                }
                /* else {
                    $idVehicule = $individualCustomerManager->insert('vehicle', $vehicle['vehicleData']);
                    $idVehiculeModel = $individualCustomerManager->insert('vehiclemodel', $vehicle['vehicleData']);
                }*/
            }
        }

        $data = $individualCustomerController->getDataforIndividualCustomer($id);

        return $this->twig->render('individualCustomer/show.html.twig', ['individualCustomer' => $data['individualCustomer'],
            'vehicles' => $data['vehicles'], 'energyTypeEnum' => $data['energyTypeEnum'], 'gearBoxTypeEnum' => $data['gearBoxTypeEnum'],
            'operation' => 'edit']);

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
        else
        {
            $data = $individualCustomerController->getDataEnumforIndividualCustomer();
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

    function cancel() {
        return header('Location:/individualCustomer/index');
    }

    function camelToSnakeCase($string, $us = "_") {
        return strtolower(preg_replace(
            '/(?<=\d)(?=[A-Za-z])|(?<=[A-Za-z])(?=\d)|(?<=[a-z])(?=[A-Z])/', $us, $string));
    }

}