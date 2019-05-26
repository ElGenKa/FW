<?php
namespace app\game_data;

class httpConnector 
{
    private $httpClient;
    private $baseUrl;
    public function __contruct($httpClient){
        $this->httpClient = $httpClient;
        $this->baseUrl = 'http://185.244.42.28/';
    }
    
    public function auth($data){
        $this->httpClient->get($this->baseUrl.'auth.php',$data);
        
    }
}