<?php

namespace App\Controller;

use App\Entity\Allow;
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

        $em = $this->getDoctrine()->getManager()->getRepository(Allow::class);

        if (empty($request->cookies->get('SSID_Fake')))
           return $this->redirectToRoute('main');


        if (!empty($request->request->all()))
        {
            if($request->cookies->get('test') != true)
            {
                $allowTests =  $em->findOneBy([

                    'UserName' => $request->cookies->get('username')

                ])->getAllowTests();

                $arrOfAllowTests = explode(',', $allowTests);

                if (!in_array($request->request->get('test_id'), $arrOfAllowTests)) die('Этот тест вам не доступен');

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

                if ($request->cookies->get('balance') >= $request->cookies->get('rand'))
                    $answerNumber = '-15';

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

            $percent = $crawler->filter('.alert > p')->eq('2')->text();

            preg_match('/[.0-9]*%/', $percent, $balance); //процент правильных вопросов

            preg_match('/value="[0-9]*/', $output, $nextQuestion);

            $questionNumber = explode('"', $nextQuestion[0]);

            setcookie('nextquestion', $questionNumber[1]);

            setcookie('balance', substr($balance[0], 0, -1));

        } catch (\InvalidArgumentException $e) {

            $past = time() - 3600;

            //setcookie('SSID_Fake', '', $past);
            setcookie('nextquestion', '', $past);
            setcookie('test', '0', $past);
            setcookie('balance', '0', $past);
            setcookie('rand', '0', $past);

        }

        echo '<base href="http://in.3level.ru" />' . $html;

    }
}


