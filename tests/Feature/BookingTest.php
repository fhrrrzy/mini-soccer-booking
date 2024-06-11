<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Field;
use App\Models\Booking;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test user registration, login, and booking a field.
     *
     * @return void
     */
    public function test_user_can_register_login_and_book_field()
    {
        // Step 1: Register a new user
        $registerResponse = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '01234567890',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $registerResponse->assertRedirect('/home');
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        // Step 2: Log in the user
        $loginResponse = $this->post('/login', [
            'email' => 'john@example.com',
            'password' => 'password',
        ]);

        $loginResponse->assertRedirect('/home');

        // Step 3: Create a field
        $field = Field::create([
            'name' => 'Test Field',
            'description' => 'This is a test field',
        ]);

        // Step 4: Book the field
        $bookingResponse = $this->post('/bookings', [
            'field_id' => $field->id,
            'date' => '2024-07-01',
            'time' => '10:00',
            'duration' => 2,
        ]);

        $bookingResponse->assertRedirect('/bookings');
        $this->assertDatabaseHas('bookings', [
            'user_id' => User::where('email', 'john@example.com')->first()->id,
            'field_id' => $field->id,
            'date' => '2024-07-01',
            'time' => '10:00',
            'duration' => 2,
        ]);
    }
}
