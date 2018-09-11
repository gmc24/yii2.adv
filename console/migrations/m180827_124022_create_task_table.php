<?php

use yii\db\Migration;

/**
 * Handles the creation of table `task`.
 */
class m180827_124022_create_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('task', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'estimation' => $this->integer() ->notNull(),
            'executor_id' => $this->integer(),
            'started_at' => $this->integer(),
            'completed_at' => $this->integer(),
            'created_by' => $this->integer() ->notNull(),
            'updated_by' => $this->integer(),
            'created_at' => $this->integer() ->notNull(),
            'updated_at' => $this->integer(),

        ]);
        $this->addForeignKey('fx_task_user_1', 'task', ['executor_id'], 'user', ['id'], 'CASCADE');
        $this->addForeignKey('fx_task_user_2', 'task', ['created_by'], 'user', ['id'], 'CASCADE');
        $this->addForeignKey('fx_task_user_3', 'task', ['updated_by'], 'user', ['id'], 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fx_task_user_3',
            'task'
        );
        $this->dropForeignKey(
            'fx_task_user_2',
            'task'
        );
        $this->dropForeignKey(
            'fx_task_user_1',
            'task'
        );

        $this->dropTable('task');
    }
}
