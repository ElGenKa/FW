<?php
namespace app\modules;

use std, gui, framework, app;


class MainModule extends AbstractModule
{

    var $music;
    var $httpConnector;

    /**
     * @event player.play 
     */
    function doPlayerPlay(ScriptEvent $e = null)
    {    
        //$this->label->text = $e->sender->position;
        $this->form('viewGame')->label->text = "Играет: ".$e->sender->position."% \r\n".$this->music['names'][$this->music['this']];
        if($e->sender->position == 100){
            if($this->music['this'] < $this->music['count']){
                $this->music['this']++;
            }else{
                $this->music['this'] = 0;
            }
            $e->sender->open($this->music['list'][$this->music['this']]);
        }
        //$this->form('viewGame')-
    }

    /**
     * @event player.construct 
     */
    function doPlayerConstruct(ScriptEvent $e = null)
    {    
        foreach (fs::scan(fs::abs('.'), ['./music/' => true, 'extensions' => ['mp3']]) as $file) {
            $music[] = $file->getAbsolutePath();
            $names[] = $file->getName();
        }
            
        $this->music['list'] = $music;    
        $this->music['this'] = rand(0,count($music));
        $this->music['count'] = count($music);
        $this->music['names'] = $names;
        
        $e->sender->volume = 0.1;
        $e->sender->autoplay = true;
        $e->sender->loop = false;
        //$e->sender->open($this->music['list'][$this->music['this']]);
    }

    /**
     * @event action 
     */
    function doAction(ScriptEvent $e = null)
    {    
        $this->httpConnector = new httpConnector($this->httpClient);
        //$resp = $this->httpClient->get();
        $this->httpClient->postAsync('http://185.244.42.28/auth.php',[], function($e){
            var_dump($e);
        });
        //$this->httpClient->execute()
        //var_dump($resp->
    }

}
