<?php

namespace common\modules\rchat\controllers;

use common\modules\rchat\components\RChat;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use yii\console\Controller;

/**
 * Default controller for the `rchat` module
 */
class WSController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionUp()
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new RChat()
                )
            ),
            8080
        );

        echo "Connected".PHP_EOL;

        $server->loop->addPeriodicTimer(5, function ()
        {
            echo date('H:i:s').PHP_EOL;
        });

        $server->run();
    }
}
