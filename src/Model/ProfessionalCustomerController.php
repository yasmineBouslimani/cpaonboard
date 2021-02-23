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

        $individualCustomersCountRequest=$individualCustomerManager->countRecords();
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


}