<?php

namespace App\Controller;

use App\Model\EmployeeManager;
use App\Model\IndividualCustomerManager;
use Symfony\Component\Console\Logger\ConsoleLogger;

class IndividualCustomerController extends AbstractController
{
    public function index(int $currentPage=1)
    {
        $individualCustomerManager = new IndividualCustomerManager();
        $individualCustomers = $individualCustomerManager->selectAll();

        return $this->twig->render('IndividualCustomer/index.html.twig', ['$individualCustomers' => $individualCustomers]);
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
        var_dump($contractTypeEnum);
        var_dump($civilityEnum);

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

        return $this->twig->render('IndividualCustomer/show.html.twig', ['entityRequest' => $data['employee'],
            'civilityEnum' => $data['civilityEnum'], 'operation' => 'read']);
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

        return $this->twig->render('IndividualCustomer/show.html.twig', ['entityRequest' => $data['employee'],
            'civilityEnum' => $data['civilityEnum'], 'operation' => 'edit']);

    }

}