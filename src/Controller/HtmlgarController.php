<?php

namespace App\Controller;

use App\Entity\Allow;
use App\Services\RequestsToGarSite;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HtmlgarController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(Request $request, RequestsToGarSite $requestsToGarSite)
    {

        $em = $this->getDoctrine()->getManager()->getRepository(Allow::class);

        if(!empty($request->cookies->get('SSID_Fake')))
            return $this->redirectToRoute('choosetest');

        if(!empty($request->request->all()))
        {
            if($em->findOneBy([

                'UserName' => $request->request->get('user_login')

            ]) == null) die('No access');

           $authToken = $requestsToGarSite->getAuth($request->request->get('user_login'), $request->request->get('user_password'));

            setcookie('SSID_Fake', $authToken);

            setcookie('rand', rand(84, 88));

            return $this->redirectToRoute('choosetest');

        }


        return $this->render('htmlgar/index.html.twig', [        ]);
    }


}
