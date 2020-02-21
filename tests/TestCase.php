<?php

namespace Tests;

use Faker\Provider\Color;
use Faker\Provider\DateTime;
use Faker\Provider\Lorem;
use Faker\Provider\pt_BR\Address;
use Faker\Provider\pt_BR\Company;
use Faker\Provider\pt_BR\Internet;
use Faker\Provider\pt_BR\Person;
use Faker\Provider\pt_BR\PhoneNumber;
use Faker\Provider\Uuid;
use RuntimeException;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;

class TestCase extends \Illuminate\Foundation\Testing\TestCase
{
    protected $faker;

    protected $allowedHosts = ['', ':memory:', '127.0.0.1', 'localhost'];

    protected $manager;

    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        if ($app->configurationIsCached()) {
            throw new RuntimeException('Your configuration is cached. Any variable in phpunit.xml did not take effect.');
        }

        $app->make(Kernel::class)->bootstrap();

        $this->protectDatabase();

        return $app;
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->faker = \Faker\Factory::create();
        $this->faker->addProvider(new Company($this->faker));
        $this->faker->addProvider(new PhoneNumber($this->faker));
        $this->faker->addProvider(new Person($this->faker));
        $this->faker->addProvider(new Address($this->faker));
        $this->faker->addProvider(new Internet($this->faker));
        $this->faker->addProvider(new DateTime($this->faker));
        $this->faker->addProvider(new Lorem($this->faker));
        $this->faker->addProvider(new Color($this->faker));
        $this->faker->addProvider(new Uuid($this->faker));

        $this->manager = app('session');

        Artisan::call('migrate');
    }

    private function protectDatabase()
    {
        $host = config('database.connections.mysql.host');

        if (!in_array($host, $this->allowedHosts)) {
            throw new RuntimeException("$host not allowed. Please change your phpunit.xml setup.");
        }

        $host = config('database.connections.sqlite.host');

        if (!in_array($host, $this->allowedHosts)) {
            throw new RuntimeException("$host not allowed. Please change your phpunit.xml setup.");
        }
    }
}
