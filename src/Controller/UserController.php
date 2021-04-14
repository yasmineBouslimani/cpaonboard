<?php


namespace App\Controller;

use App\Model\EmployeeManager;
use App\Model\UserManager;

class UserController extends AbstractController
{

    public function index()
    {
        if (!in_array("AU", $_SESSION['permissions'])) {
            header('location:/admin/index');
        }
        $userManager = new UserManager();
        $inactiveUsers = $userManager->selectAllInactiveUsers();
        $activeUsers = $userManager->selectAllActiveUsers();

        return $this->twig->render('User/index.html.twig', [
            'inactiveUsers' => $inactiveUsers,
            'activeUsers' => $activeUsers
        ]);
    }


    public function show($id)
    {
        if (!in_array("AU", $_SESSION['permissions'])) {
            header('location:/admin/index');
        }

        $userManager = new UserManager();
        $user = $userManager->getUserWithEmployeeById($id);
        $permissions = json_decode($user['permissions']);

        return $this->twig->render('User/show.html.twig', [
            'user' => $user,
            'permissions' => $permissions
        ]);
    }


    public function edit(int $id)
    {
        if (!in_array("AU", $_SESSION['permissions'])) {
            header('location:/admin/index');
        }
        $userManager = new UserManager();
        $user = $userManager->getUserWithEmployeeById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user['login'] = $_POST['login'];
            $user['is_active'] = $_POST['is_active'];
            $user['permissions'] = json_encode($_POST['permissions']);
            $userManager->updateUser($user);

            header('Location: /user/index/');
        }

        return $this->twig->render('User/edit.html.twig', [
                'user' => $user,
            ]
        );
    }

    public function add()
    {
        if (!in_array("AU", $_SESSION['permissions'])) {
            header('location:/admin/index');
        }

        $employeeManager = new EmployeeManager();
        $employees = $employeeManager->selectAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userManager = new UserManager();
            $user['login'] = $_POST['login'];
            $user['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $user['is_active'] = $_POST['is_active'];
            $user['permissions'] = json_encode($_POST['permissions']);
            $user['fk_id_employee'] = $_POST['fk_id_employee'];

            $id = $userManager->insertUser($user);
            header('Location:/user/show/' . $id);
        }

        return $this->twig->render('User/add.html.twig', [
            'employees' => $employees,
        ]);
    }

    public function delete(int $id)
    {
        if (!in_array("AU", $_SESSION['permissions'])) {
            header('location:/user/index');
        }
        $userManager = new UserManager();
        $userManager->delete('users', $id);
        header('Location:/user/index');
    }


    public function cpaDatum()
    {
        $userManager = new UserManager();
        $user['login'] = 'BDXDG';
        $user['password'] = password_hash('secret', PASSWORD_DEFAULT);
        $user['is_active'] = 1;
        $user['permissions'] = json_encode(["AU", "GP", "GCPP", "GL", "DA", "GA", "GV", "GC"]);
        $user['fk_id_employee'] = 1;
        $userManager->insertUser($user);
        $user['login'] = 'BDXRH';
        $user['password'] = password_hash('secret', PASSWORD_DEFAULT);
        $user['is_active'] = 1;
        $user['permissions'] = json_encode(["GC"]);
        $user['fk_id_employee'] = 3;
        $userManager->insertUser($user);
        $user['login'] = 'BDXVD';
        $user['password'] = password_hash('secret', PASSWORD_DEFAULT);
        $user['is_active'] = 1;
        $user['permissions'] = json_encode(["GP", "GCPP", "GL", "GV"]);
        $user['fk_id_employee'] = 5;
        $userManager->insertUser($user);
        $user['login'] = 'BDXCO';
        $user['password'] = password_hash('secret', PASSWORD_DEFAULT);
        $user['is_active'] = 1;
        $user['permissions'] = json_encode(["GP", "GCPP", "GL", "GA", "GV"]);
        $user['fk_id_employee'] = 2;
        $userManager->insertUser($user);
    }
}