<?php


namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{

    public function index()
    {
        /**
         * @return string
         * @throws \Twig\Error\LoaderError
         * @throws \Twig\Error\RuntimeError
         * @throws \Twig\Error\SyntaxError
         */
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
        /**
         * @param $id
         * @return string
         * @throws \Twig\Error\LoaderError
         * @throws \Twig\Error\RuntimeError
         * @throws \Twig\Error\SyntaxError
         */
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
        /**
         * @param int $id
         * @return string
         * @throws \Twig\Error\LoaderError
         * @throws \Twig\Error\RuntimeError
         * @throws \Twig\Error\SyntaxError
         */
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

}