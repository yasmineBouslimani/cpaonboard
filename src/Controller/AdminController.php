<?php

namespace App\Controller;

class AdminController extends AbstractController
{
    public function index()
    {
/*        if ($_SESSION['fk_id_userType'] != '1') {
            header('location:/auth/login');
        }*/
        return $this->twig->render('Admin/index.html.twig');
    }
}