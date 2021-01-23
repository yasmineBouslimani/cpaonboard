<?php


namespace App\Controller;

use EmployeeModel;

class EmployeeController extends AbstractController
{
    public function index()
    {
        /*$employeeModel = new EmployeeModel();
        $employeesCount = $employeeModel->getEmployeesCountForTable();

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
        //            END PENDING DB CONNECTION ___________________

        if(isset($_GET['page']) && !empty($_GET['page'])) {
            $currentPage = (int)strip_tags($_GET['page']);
//            PENDING DB CONNECTION ___________________
            if ($currentPage == 1)
            {
                $employees=$employees1;
            }elseif ($currentPage == 2) {
            $employees= ['employee_id' => 6, 'active' => '1', 'employee_hr_id' => 'BDX4624','firstName' => 'Chloé',
                'lastName' => 'Laforge', 'service' => 'Stock & Magasin', 'function' => 'Magasinier'];
            }
            //            END PENDING DB CONNECTION ___________________
        }else{
          $currentPage = 1;
            //            PENDING DB CONNECTION ___________________
          $employees=$employees1;
            //            END PENDING DB CONNECTION ___________________
      }

        $employeesCount=6;

        return $this->twig->render('Employee/showEmployees.html.twig', ['test' => 'it works', 'employees' => $employees,
            'employeesCount' => $employeesCount]);
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