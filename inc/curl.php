<?php
/**
 * Created by PhpStorm.
 * User: nhansay
 * Date: 8/31/2016
 * Time: 10:51 AM
 */

include 'random-agent.php';

/**
 * Curl PHP
 */
if ( !function_exists( 'sunfrog_curl' ) )
{
    function sunfrog_curl($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_REFERER, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT , 0);
        // random user agent
        curl_setopt($curl, CURLOPT_USERAGENT, sunfrog_random_user_agent());

        $str = curl_exec($curl);
        curl_close($curl);
        return $str;
    }
}