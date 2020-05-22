<?php declare(strict_types = 1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ErrorController extends AbstractController
{
    public function errorAction()
    {
        return $this->render('security/access-denied.html.twig');
    }
}