<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ClearController extends AbstractController
{
    /**
     * @Route("/clear", name="clear")
     */
    public function index()
    {
        $past = time() - 3600;

        setcookie('SSID_Fake', '', $past);
        setcookie('nextquestion', '', $past);
        setcookie('test', '0', $past);

        return $this->render('clear/index.html.twig', [
        ]);
    }
}
