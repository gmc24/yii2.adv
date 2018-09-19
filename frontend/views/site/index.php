<?php

/* @var $this yii\web\View */

$this->title = 'My Task Manager';
?>



<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You are using simple Task Manager yii2-application.</p>

    </div>

    <div class="body-content">

        <div class="row">
           <h2 class="text-center">Start with your Projects or Tasks</h2>
            <div class="col-lg-6">
                <h2>Projects</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="<?=\yii\helpers\Url::to('/project/index')?>">My projects &raquo;</a></p>
            </div>
            <div class="col-lg-6">
                <h2>Tasks</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="<?=\yii\helpers\Url::to('/task/index')?>">My tasks &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
