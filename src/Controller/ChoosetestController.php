<?php

namespace App\Controller;

use App\Services\RequestsToGarSite;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ChoosetestController extends AbstractController
{
    /**
     * @Route("/test", name="choosetest")
     */
    public function index(Request $request, RequestsToGarSite $requestsToGarSite)
    {
        $isTest = false;

        if (empty($request->cookies->get('SSID_Fake')))
           return $this->redirectToRoute('main');


        if (!empty($request->request->all()))
        {
            if($request->cookies->get('test') != true)
            {
                setcookie('test', true);

                $dataAboutTestChoice = http_build_query([

                    'section_id' => $request->request->get('section_id'),
                    'test_id' => $request->request->get('test_id'),
                    'submit_button' => 'Выбрать',

                ]);

                echo $requestsToGarSite->getHtml('http://in.3level.ru/?module=testing', $request->cookies->get('SSID_Fake'), $dataAboutTestChoice);

                $isTest = true;

            } else {

                $answer = http_build_query([

                    'answer' => '3',
                    'current_question' => '12111',
                    'submit_button' => 'Ответить',

                ]);

                echo $requestsToGarSite->getHtml('http://in.3level.ru/?module=testing', $request->cookies->get('SSID_Fake'), $answer);

                $isTest = true;
            }




        }



        return $this->render('choosetest/index.html.twig', [
            'isTest' => $isTest
        ]);
    }
}
