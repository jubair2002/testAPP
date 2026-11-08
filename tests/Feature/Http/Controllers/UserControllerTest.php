<?php

namespace Tests\Feature\Http\Controllers;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function test_root_redirects_to_the_user_directory(): void
    {
        $this->get('/')
            ->assertRedirect('/users');
    }

    public function test_user_creation_form_is_available_without_database_access(): void
    {
        $response = $this->get('/users/create');

        $response->assertOk()
            ->assertSee('Add user')
            ->assertSee('name="username"', false)
            ->assertSee('name="email"', false)
            ->assertSee('name="age"', false);
    }
}
