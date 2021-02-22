<?php

namespace App\Controller;

use App\Model\EmployeeManager;
use App\Service\FormValidator;
use App\Service\Mailer;

class EmployeeController extends AbstractController
{


    public function index(int $currentPage = 1)
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

        $employeesCountRequest = $employeeManager->countRecords();
        $employeesCount = $employeesCountRequest[0]['countRecords'];
        $resultsPerPage = 5;
        $pagesCount = ceil($employeesCount / $resultsPerPage);
        $firstResult = ($currentPage * $resultsPerPage) - $resultsPerPage;
        $employees = $employeeManager->selectEmployeesAndContactsData($resultsPerPage, $firstResult);
        $paginationDefaultPagesGap = 2;


        return $this->twig->render('Employee/index.html.twig', ['resultPerPage' => $resultsPerPage, 'employees' => $employees,
            'employeesCount' => $employeesCount, 'pagesCount' => $pagesCount, 'currentPage' => $currentPage,
            'paginationDefaultPagesGap' => $paginationDefaultPagesGap]);
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


        $employeeController = new EmployeeController();
        $data = $employeeController->getDataforEmployeeCrud($id);

        return $this->twig->render('Employee/showEmployee.html.twig', ['entityRequest' => $data['employee'],
            'civilityEnum' => $data['civilityEnum'], 'operation' => 'read']);
    }

    public function getDataforEmployeeCrud(int $id): array
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

        $employee = $employeeManager->selectEmployeeById($id);
        $civilityEnumRequest = $employeeManager->selectCivilityEnum();
        $civilityEnum = $employeeManager->selectCivilityEnum();
        /*$civilityEnumConcat = substr( $civilityEnumRequest['Type'], 5, -1);
        $civilityEnum = explode( "','", $civilityEnumConcat );*/
        var_dump($civilityEnum);

        return ['employee' => $employee, 'civilityEnum' => $civilityEnum];
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

        $employeeController = new EmployeeController();
        $data = $employeeController->getDataforEmployeeCrud($id);

        return $this->twig->render('Employee/showEmployee.html.twig', ['entityRequest' => $data['employee'],
            'civilityEnum' => $data['civilityEnum'], 'operation' => 'edit']);

    }


    public function contactForm()
    {
        return $this->twig->render('Email/formEmail.html.twig');
    }

    public function notify()
    {
        $contactFormValidator = new FormValidator();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $identifier = $contactFormValidator->verifyInput($_POST['employee_hr_id']);
            $message = $contactFormValidator->verifyInput($_POST["message"]);
            $subject = $_POST["subject"];

            $isSuccess = true;
            $emailText = "";
            $identifierError = '';
            $messageError = '';

            if (!$identifier) {
                $identifierError = "Veuillez indiquer votre indentifiant.";
                $isSuccess = false; // Si erreur, alors ne pas afficher le message
            } else
                $emailText .= "Firstname : $identifier\n";

            if (empty($message)) {
                $messageError = "Veuillez indiquer le contenu de l'email.";
                $isSuccess = false;
            } else
                $emailText .= "Message : $message\n";

            if ($isSuccess) {
                $mailer = new Mailer();
                $mailer->notifyEmployee($subject, $identifier, $message);
                header('Location:/product/index');
            }
            return $this->twig->render('Email/formEmail.html.twig', [
                'messageError' => $messageError,
                'identifierError' => $identifierError
            ]);
        }
    }


}