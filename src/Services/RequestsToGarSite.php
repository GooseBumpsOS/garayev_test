<?php


namespace App\Services;


class RequestsToGarSite
{

    public function getHtml($urlTo, $ssid = '', $postData='')
    {

        //$urlTo = 'http://in.3level.ru/?module=testing'; // Куда данные послать

        $ch = curl_init(); // Инициализация сеанса
        curl_setopt($ch, CURLOPT_URL, $urlTo); // Куда данные послать
        curl_setopt($ch, CURLOPT_HEADER, 0); // получать заголовки
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36');
        curl_setopt($ch, CURLOPT_REFERER, 'http://in.3level.ru');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            $postData);
        curl_setopt($ch, CURLOPT_COOKIE, "SID=" . $ssid);
        curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Expect:')); // это необходимо, чтобы cURL не высылал заголовок на ожидание
        $tempRes = curl_exec($ch);
        curl_close($ch); // Завершаем сеанс

        return $tempRes;
    }

    public function getAuth($userName, $pass)
    {
        $urlTo = 'http://in.3level.ru/?module=login'; // Куда данные послать


        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $urlTo);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_HEADER, 1);
//get only headers
        curl_setopt($ch, CURLOPT_NOBODY, 1);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            "user_login={$userName}&submit_button=Вход&user_password={$pass}");

        $output = curl_exec($ch);

        curl_close($ch);

        preg_match('/SID=[A-Za-z0-9 ]*/', $output, $preg_str);
        $preg_str = substr($preg_str[0], 4);

        return $preg_str;
    }

}