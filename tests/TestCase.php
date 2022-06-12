<?php

namespace Tests;

use Database\Seeders\ImageSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

	protected function setUp(): void
	{
		parent::setUp();
		$this->runSeeders();
	}

	private function runSeeders()
	{
		$this->seed([
			UserSeeder::class,
			ImageSeeder::class
		]);
	}
}
