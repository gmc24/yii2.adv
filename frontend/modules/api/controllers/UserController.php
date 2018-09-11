<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 11.09.2018
 * Time: 2:07
 */

namespace app\modules\api\controllers;

use yii\rest\ActiveController;

class UserController extends ActiveController
{
    public $modelClass = 'frontend\modules\api\models\User';
}