<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    public $seed = true;

    protected function admin()
    {
        return $this->actingAs(User::factory()->admin()->create());
    }

    protected function customer()
    {
        return $this->actingAs(User::factory()->customer()->create());
    }
}
