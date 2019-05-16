<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MaxresultController extends AbstractController
{
    /**
     * @Route("/max", name="maxresult")
     */
    public function index(Request $request)
    {
        if (!empty($request->query->get('max')))
        {
            $maxResult = $request->query->get('max');

            setcookie('rand', $maxResult);

            echo 'Ok. Ваш максимальный балл на все тесты - ' . $request->cookies->get('rand');

        }


        return $this->render('maxresult/index.html.twig', [
            'controller_name' => 'MaxresultController',
        ]);
    }
}
