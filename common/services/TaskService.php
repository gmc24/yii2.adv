<?php

namespace common\services;

use common\models\Project;
use common\models\ProjectUser;
use common\models\Task;
use common\models\User;
use yii\base\Component;

class TaskService extends Component
{
    public function getAvailableProjects($id)
    {
        return Project::find()->byUser($id)->select('title')->indexBy('id')->column();
    }

    public function canManage(Project $project, User $user)
    {
        return \Yii::$app->projectService->hasRole($project, $user, ProjectUser::ROLE_MANAGER);
    }

    public function canTake(Task $task, User $user)
    {
        return \Yii::$app->projectService->hasRole($task->project, $user, ProjectUser::ROLE_DEVELOPER) && $task->executor_id === null;
    }

    public function canComplete(Task $task, User $user)
    {
        return ($task->executor_id == $user->id && $task->completed_at === null);
    }

    public function takeTask(Task $task, User $user)
    {
        $task->executor_id = $user->id;
        $task->started_at = time();

        return $task->save();
    }

    public function completeTask(Task $task)
    {
        $task->completed_at = time();
        return $task->save();
    }
}