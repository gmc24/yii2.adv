<?php

namespace frontend\controllers;

use Codeception\Lib\Generator\Helper;
use yii\helpers\VarDumper;
use yii\web\Controller;

class HelloController extends Controller
{
    public function actionIndex()
    {
//        return $this->render('index',[]);
        return VarDumper::dumpAsString(\Yii::$aliases, 10, true);
    }
}