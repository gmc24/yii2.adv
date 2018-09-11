<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 11.09.2018
 * Time: 2:07
 */

namespace app\modules\api\controllers;

use frontend\modules\api\models\Project;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;

class ProjectController extends Controller
{
    public function actionIndex()
    {
        $dp = new ActiveDataProvider(['query' => Project::find()]);
        return $dp;
    }

    public function actionView($id)
    {
        return Project::findOne($id);
    }
}