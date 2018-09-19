<?php

namespace common\services;

use common\models\Project;
use common\models\Task;
use common\models\User;
use yii\helpers\ArrayHelper;

class AssignRoleEvent extends \yii\base\Event
{
    public $project;
    public $user;
    public $role;

    public function dump()
    {
        return ['project' => $this->project->id, 'user' => $this->user->id, 'role' => $this->role];
    }
}

class ProjectService extends \yii\base\Component
{
    const EVENT_ASSIGN_ROLE = 'event_assign_role';

    public function getRoles(Project $project, User $user)
    {
        return $project->getProjectUsers()->byUser($user->id)->select('role')->column();
    }

    public function hasRole(Project $project, User $user, $role)
    {
        return in_array($role, $this->getRoles($project, $user));
    }

    public function getActiveExecutorsInAvailableProjects(User $user)
    {
        $executors = User::find()->select(['id', 'username'])->where(['in', 'id',
            \common\models\ProjectUser::find()->select('user_id')->distinct()->where(['<>','role', \common\models\ProjectUser::ROLE_TESTER])
                ->andWhere(['in', 'project_id',
                    \common\models\ProjectUser::find()->byUser($user->id)->column()
                ])
                ->andWhere(['in', 'user_id', \common\models\User::find()->onlyActive()->column()])
                ->column()
            ])->asArray()->all();

        return ArrayHelper::map($executors, 'id', 'username');
    }

    /**
     * @param \common\models\User $user
     * @param \common\models\Project $project
     * @param string $role
     */
    public function assignRole(Project $project, User $user, $role)
    {
        $event = new AssignRoleEvent();
        $event->project = $project;
        $event->user = $user;
        $event->role = $role;
        $this->trigger(self::EVENT_ASSIGN_ROLE, $event);
    }


}