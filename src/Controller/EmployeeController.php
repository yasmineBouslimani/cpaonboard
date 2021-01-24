<?php


namespace App\Controller;

use EmployeeModel;

class EmployeeController extends AbstractController
{
    public function index(int $currentPage=1)
    {

        $employeesCount=26;
        $resultsPerPage = 5;
        $pagesCount = ceil($employeesCount / $resultsPerPage);
        $firstResult = ($currentPage * $resultsPerPage) - $resultsPerPage;
        $paginationDefaultPagesGap = 2;

        /*$employeeModel = new EmployeeModel();
        $employeesCount = $employeeModel->getEmployeesCountForTable($firstResult, $resultsPerPage);

        $employees = $employeeModel->getEmployeesForTable();*/


        //            PENDING DB CONNECTION ___________________
        $employees1=[
            ['employeeId' => 1, 'active' => '1','employee_hr_id' => 'BDX2389','firstName' => 'Nathalie', 'lastName' => 'De Lauret', 'service' =>
                'Direction', 'function' => 'Directeur'],
            ['employeeId' => 2, 'active' => '1', 'employee_hr_id' => 'BDX78JU','firstName' => 'Myriam', 'lastName' => 'Mitier', 'service' =>
                'Accueil', 'function' => 'Assistante RH'],
            ['employeeId' => 3, 'active' => '0', 'employee_hr_id' => 'BDX6783','firstName' => 'Mathilde', 'lastName' => 'Dubois', 'service' =>
                'Finance & achats', 'function' => 'Commerciale'],
            ['employeeId' => 4, 'employee_hr_id' => 'BDXYH89','firstName' => 'Laurent', 'lastName' => 'Dupuis', 'service' =>
                'Moteur & dépendance', 'function' => 'Vendeur'],
            ['employeeId' => 5, 'active' => '1', 'employee_hr_id' => 'BDX4624','firstName' => 'Chloé', 'lastName' => 'Laforge', 'service' =>
                'Stock & Magasin', 'function' => 'Magasinier'],
        ];
        $employees2=[
            ['employeeId' => 1, 'active' => '1','employee_hr_id' => 'BDX2378','firstName' => 'Prenom2', 'lastName' => 'Nom2', 'service' =>
                'Direction', 'function' => 'Directeur'],
            ['employeeId' => 2, 'active' => '1', 'employee_hr_id' => 'BDX78JU','firstName' => 'Prenom2', 'lastName' => 'Nom2', 'service' =>
                'Accueil', 'function' => 'Assistante RH'],
            ['employeeId' => 3, 'active' => '0', 'employee_hr_id' => 'BDX6783','firstName' => 'Prenom2', 'lastName' => 'Nom2', 'service' =>
                'Finance & achats', 'function' => 'Commerciale'],
            ['employeeId' => 4, 'employee_hr_id' => 'BDXYH89','firstName' => 'Prenom2', 'lastName' => 'Nom2', 'service' =>
                'Moteur & dépendance', 'function' => 'Vendeur'],
            ['employeeId' => 5, 'active' => '1', 'employee_hr_id' => 'BDX4624','firstName' => 'Prenom2', 'lastName' => 'Nom2', 'service' =>
                'Stock & Magasin', 'function' => 'Magasinier'],
        ];
        $employees3=[
            ['employeeId' => 1, 'active' => '1','employee_hr_id' => 'BDX2378','firstName' => 'Prenom3', 'lastName' => 'Nom3', 'service' =>
                'Direction', 'function' => 'Directeur'],
            ['employeeId' => 2, 'active' => '1', 'employee_hr_id' => 'BDX78JU','firstName' => 'Prenom3', 'lastName' => 'Nom3', 'service' =>
                'Accueil', 'function' => 'Assistante RH'],
            ['employeeId' => 3, 'active' => '0', 'employee_hr_id' => 'BDX6783','firstName' => 'Prenom3', 'lastName' => 'Nom3', 'service' =>
                'Finance & achats', 'function' => 'Commerciale'],
            ['employeeId' => 4, 'employee_hr_id' => 'BDXYH89','firstName' => 'Prenom3', 'lastName' => 'Nom3', 'service' =>
                'Moteur & dépendance', 'function' => 'Vendeur'],
            ['employeeId' => 5, 'active' => '1', 'employee_hr_id' => 'BDX4624','firstName' => 'Prenom3', 'lastName' => 'Nom3', 'service' =>
                'Stock & Magasin', 'function' => 'Magasinier'],
        ];
        $employees4=[
            ['employeeId' => 1, 'active' => '1','employee_hr_id' => 'BDX2378','firstName' => 'Prenom4', 'lastName' => 'Nom4', 'service' =>
                'Direction', 'function' => 'Directeur'],
            ['employeeId' => 2, 'active' => '1', 'employee_hr_id' => 'BDX78JU','firstName' => 'Prenom4', 'lastName' => 'Nom4', 'service' =>
                'Accueil', 'function' => 'Assistante RH'],
            ['employeeId' => 3, 'active' => '0', 'employee_hr_id' => 'BDX6783','firstName' => 'Prenom4', 'lastName' => 'Nom4', 'service' =>
                'Finance & achats', 'function' => 'Commerciale'],
            ['employeeId' => 4, 'employee_hr_id' => 'BDXYH89','firstName' => 'Prenom4', 'lastName' => 'Nom4', 'service' =>
                'Moteur & dépendance', 'function' => 'Vendeur'],
            ['employeeId' => 5, 'active' => '1', 'employee_hr_id' => 'BDX4624','firstName' => 'Prenom4', 'lastName' => 'Nom4', 'service' =>
                'Stock & Magasin', 'function' => 'Magasinier'],
        ];
        $employees5=[
            ['employeeId' => 1, 'active' => '1','employee_hr_id' => 'BDX2378','firstName' => 'Prenom5', 'lastName' => 'Nom5', 'service' =>
                'Direction', 'function' => 'Directeur'],
            ['employeeId' => 2, 'active' => '1', 'employee_hr_id' => 'BDX78JU','firstName' => 'Prenom5', 'lastName' => 'Nom5', 'service' =>
                'Accueil', 'function' => 'Assistante RH'],
            ['employeeId' => 3, 'active' => '0', 'employee_hr_id' => 'BDX6783','firstName' => 'Prenom5', 'lastName' => 'Nom5', 'service' =>
                'Finance & achats', 'function' => 'Commerciale'],
            ['employeeId' => 4, 'employee_hr_id' => 'BDXYH89','firstName' => 'Prenom5', 'lastName' => 'Nom5', 'service' =>
                'Moteur & dépendance', 'function' => 'Vendeur'],
            ['employeeId' => 5, 'active' => '1', 'employee_hr_id' => 'BDX4624','firstName' => 'Prenom5', 'lastName' => 'Nom5', 'service' =>
                'Stock & Magasin', 'function' => 'Magasinier'],
        ];

        $employees6= [['employee_id' => 6, 'active' => '1', 'employee_hr_id' => 'BDX4624','firstName' => 'Chloé',
            'lastName' => 'Laforge', 'service' => 'Stock & Magasin', 'function' => 'Magasinier']];
//           END PENDING DB CONNECTION ___________________


        // PENDING DB CONNECTION ___________________
        if ($currentPage == 1)
        {
            $employees=$employees1;
        }elseif ($currentPage == 2) {
            $employees= $employees2;
        } elseif ($currentPage == 3) {
            $employees= $employees3;
        } elseif ($currentPage == 4) {
            $employees= $employees4;
        } elseif ($currentPage == 5) {
            $employees= $employees5;
        } elseif ($currentPage == 6) {
            $employees= $employees6;
        }
        // END PENDING DB CONNECTION ___________________

            $test = 'on page 1';
        if ($currentPage == 2)
            $test = 'on page 2';

        return $this->twig->render('Employee/showEmployees.html.twig', ['resultPerPage' => $resultsPerPage, 'employees' => $employees,
            'employeesCount' => $employeesCount, 'pagesCount' => $pagesCount, 'currentPage' => $currentPage, 'test' => $test,
            'paginationDefaultPagesGap' => $paginationDefaultPagesGap]);
    }

    public function show(int $id)
    {
        // PENDING DB CONNECTION ___________________
        $employee=['employeeId' => 1, 'active' => '1','employee_hr_id' => 'BDX2389','firstName' => 'Nathalie', 'lastName' => 'De Lauret',
            'service' => 'Direction', 'function' => 'Directeur'];
        // END PENDING DB CONNECTION ___________________

        return $this->twig->render('Employee/showEmployee.html.twig', ['employee' => $employee, 'tempEmployeeId' =>
            $id]);
    
    }


}