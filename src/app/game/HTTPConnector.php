<?php
/**
 * Created by PhpStorm.
 * User: ElGen
 * Date: 30.05.2019
 * Time: 22:23
 */

namespace app\game;


class HTTPConnector
{
    private $baseUrl;
    public function __contruct(){
        $this->baseUrl = 'http://185.244.42.28/';
    }
}