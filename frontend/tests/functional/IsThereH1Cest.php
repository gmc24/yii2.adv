<?php
namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;

class IsThereH1Cest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    /**
     * @dataProvider pageProvider
     */
    public function tryToTest(FunctionalTester $I, \Codeception\Example $example)
    {
        $I->amOnPage($example['page']);
        $I->see($example['header'], 'h1');
    }

    /**
     * @return array
     */
    protected function pageProvider()
    {
        return [
            ['page'=>"/", 'header'=>"Congratulations!"],
            ['page'=>"/site/about", 'header'=>"About"],
            ['page'=>"/site/contact", 'header'=>"Contact"],
            ['page'=>"/site/signup", 'header'=>"Signup"],
            ['page'=>"/site/login", 'header'=>"Login"],
            ['page'=>"/site/request-password-reset", 'header'=>"Request password reset"],
            ['page'=>"/hello", 'header'=>"Hello, world!"],
        ];
    }
}
