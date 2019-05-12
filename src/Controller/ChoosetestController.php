<?php

namespace App\Controller;

use App\Services\RequestsToGarSite;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DomCrawler\Crawler;
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

                $this->parseAndPrintHtml($requestsToGarSite->getHtml('http://in.3level.ru/?module=testing', $request->cookies->get('SSID_Fake'), $dataAboutTestChoice));

                $isTest = true;

            } else {

                $answerNumber = file_get_contents("http://gt.qpr0g.ru/get?questionId={$request->cookies->get('nextquestion')}&token=fPUnR2HU6jfVcfcGu93976A7pL4xa7cn");

                $answer = http_build_query([

                    'answer' => json_decode($answerNumber,  true),
                    'current_question' => $request->cookies->get('nextquestion'),
                    'submit_button' => 'Ответить',

                ]);

                $this->parseAndPrintHtml($requestsToGarSite->getHtml('http://in.3level.ru/?module=testing', $request->cookies->get('SSID_Fake'), $answer));

                $isTest = true;
            }




        }



        return $this->render('choosetest/index.html.twig', [
            'isTest' => $isTest
        ]);
    }

    private function parseAndPrintHtml($html){

        try {
            $crawler = new Crawler($html);

            $output = $crawler->filter('form')->html();

            preg_match('/value="[0-9]*"/', $output, $preg_str);

            $questionNumber = explode('"', $preg_str[0]);

            setcookie('nextquestion', $questionNumber[1]);
        } catch (Exception $e) {

        }



        echo $html;

    }
}


