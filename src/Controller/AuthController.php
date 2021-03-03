<?php

namespace App\Controller;

use App\Model\UserManager;

class AuthController extends AbstractController
{
    public function login(): string
    {
        return $this->twig->render('Auth/index.html.twig');
    }

    public function check(): string
    {
        $userManager = new userManager();
        $userData = $userManager->selectOneByUserLogin($_POST['login']);
        $detailsError = "";

        if (($_POST['password'] == $userData['password'])) {
            $_SESSION['login'] = ucfirst($_POST['login']);
            $_SESSION['fk_id_userType'] = $userData['fk_id_userType'];
            header('Location: /admin/index/');
        } else {
            $detailsError = "Vos details sont incorrects. ";
        }

        return $this->twig->render('Auth/index.html.twig', [
            'userData' => $userData,
            'detailsError' => $detailsError,
        ]);
    }

    public function logout()
    {
        session_destroy();
        header('Location: /auth/login');
    }

}