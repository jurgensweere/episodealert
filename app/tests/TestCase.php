<?php namespace EA\tests;

use Artisan;
use Mail;
use EA\models\User;

class TestCase extends \Illuminate\Foundation\Testing\TestCase
{
    /**
     * Creates the application.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        $unitTesting = true;

        $testEnvironment = 'testing';

        return require __DIR__.'/../../bootstrap/start.php';
    }

    /**
     * Migrates the database and set the mailer to 'pretend'.
     * This will cause the tests to run quickly.
     *
     */
    private function prepareForTests()
    {
        Artisan::call('migrate');
        $this->seed();
        Mail::pretend(true);
    }

    /**
     * Default preparation for each test
     *
     */
    public function setUp()
    {
        parent::setUp();
     
        $this->prepareForTests();
    }

    public function teardownDb()
    {
        Artisan::call('migrate:reset');
    }

    public function beAdmin()
    {
        $user = User::find(1);
        $this->be($user);
    }
}
