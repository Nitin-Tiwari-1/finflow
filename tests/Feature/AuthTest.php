<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase; // Automatically rolls back database changes after each test

    /** @test */
    public function a_user_can_register()
    {
        $response = $this->post(route('register.custom'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertCount(1, User::all()); // Check that a user was created
        $this->assertEquals('Test User', User::first()->name); // Check the user's name
        $response->assertRedirect(route('dashboard')); // Check redirection after registration
        $response->assertSessionHas('success'); // Check session success message
    }

    /** @test */
    public function a_user_can_login()
    {
        // First, create a user
        $user = User::factory()->create([
            'password' => bcrypt('password'), // Ensure the password is hashed
        ]);

        // Attempt to log in
        $response = $this->post(route('login.custom'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('dashboard')); // Check redirection after login
        $this->assertAuthenticatedAs($user); // Check that the user is authenticated
        $response->assertSessionHas('success'); // Check session success message
    }

    /** @test */
    public function a_user_cannot_login_with_invalid_credentials()
    {
        $response = $this->post(route('login.custom'), [
            'email' => 'wrong@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect(route('login')); // Check redirection after failed login
        $response->assertSessionHasErrors('emailPassword'); // Check error message
    }
}
