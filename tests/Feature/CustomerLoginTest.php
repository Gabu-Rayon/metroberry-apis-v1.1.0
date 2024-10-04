<?php
 namespace Tests\Feature;

use App\Models\CustomerLogin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class CustomerLoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function customer_can_login_with_valid_credentials()
    {
        // Arrange: Create a test customer
        $customer = CustomerLogin::create([
            'name' => 'Test User',
            'username' => 'testuser',
            'organisation_id' => 1,
            'customer_organisation_code' => 'ORG123',
            'contact' => '1234567890',
            'email' => 'testuser@example.com',
            'home_address' => '123 Test Street',
            'password' => Hash::make('12345'),
            'avatar' => 'default.png',
            'is_email_verified' => true,
            'is_contact_verified' => true,
        ]);
        $customer ->save();

        // Act: Make a POST request to the customerLogin endpoint
        $response = $this->postJson('/api/customerLogin', [
            'username' => 'testuser',
            'password' => '12345',
        ]);

        // Assert: Check that the response status is 200 and contains a token
        $response->assertStatus(200);
        $response->assertJsonStructure(['message', 'token']);
    }

    /** @test */
    public function customer_cannot_login_with_invalid_credentials()
    {
        // Arrange: Create a test customer
        $customer = CustomerLogin::create([
            'name' => 'Test User',
            'username' => 'testuser',
            'organisation_id' => 1,
            'customer_organisation_code' => 'YAL',
            'contact' => '1234567890',
            'email' => 'testuser@example.com',
            'home_address' => '123 Test Street',
            'password' => Hash::make('12345'),
            'avatar' => 'default.png',
            'is_email_verified' => true,
            'is_contact_verified' => true,
        ]);

        // Act: Make a POST request to the customerLogin endpoint with invalid credentials
        $response = $this->postJson('/api/customerLogin', [
            'username' => 'testuser',
            'password' => 'wrongpassword',
        ]);

        // Assert: Check that the response status is 401 and contains the error message
        $response->assertStatus(401);
        $response->assertJson(['message' => 'Invalid username or password']);
    }
}