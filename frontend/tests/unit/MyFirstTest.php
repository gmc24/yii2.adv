<?php
namespace frontend\tests\unit;

use frontend\models\ContactForm;

class MyFirstTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $x = 5;

        $this->assertTrue($x == 5);
        $this->assertEquals(5, $x);
        $this->assertLessThan(6, $x);

        $cf = new ContactForm();

        $cf->attributes = [
            'name' => 'User',
            'email' => 'user@mail.com',
            'subject' => 'welcome',
            'body' => 'some text',
        ];
        $this ->assertAttributeEquals('User', 'name', $cf, $message = 'Here it is!');

        $this->assertArrayHasKey('body', $cf->attributes);
    }
}