<?php
/**
 * Created by PhpStorm.
 * User: ElGen
 * Date: 30.05.2019
 * Time: 22:23
 */

namespace app\game;


use php\lang\Thread;
use php\time\Time;
use php\time\Timer;

class HTTPConnector
{
    private $baseUrl;
    /** @var Timer */
    private $timer_ping;
    public $last_ping;

    /**
     *
     */
    public function __contruct()
    {
        $this->baseUrl = 'http://185.244.42.28/';
    }

    /**
     * Start timer
     */
    public function start_ping()
    {
        $last_ping_link = $this->last_ping;
        $base_url = $this->baseUrl;
        $this->timer_ping = Timer::setInterval(function ($timer) use ($last_ping_link,$base_url) {
            $thread = new Thread(
                function ($thread) use ($timer, $last_ping_link, $base_url) {
                    $time = microtime(true);
                    file_get_contents($base_url . "gameApi/api.php?method=ping");
                    $last_ping_link = floor((microtime(true) - $time) * 1000);
            });
            $thread->start();
        }, 1000);
    }

    /**
     * Stop timer
     */
    public function stop_ping()
    {
        $this->timer_ping->cancel();
    }
}