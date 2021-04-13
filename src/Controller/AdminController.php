<?php

namespace App\Controller;

class AdminController extends AbstractController
{
    public function index()
    {
        if (is_null($_SESSION['permissions'])) {
            header('location:/auth/login');
        }
        return $this->twig->render('Admin/index.html.twig');
    }
}