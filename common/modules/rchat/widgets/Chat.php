<?php

namespace common\modules\rchat\widgets;

use common\modules\rchat\widgets\assets\RchatAsset;

class Chat extends \yii\bootstrap\Widget
{
    public $port = 8080;
    public function init()
    {
        RchatAsset::register($this->view);
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->view->registerJsVar('wsPort', $this->port);
        return $this->render('rchat');
    }
}