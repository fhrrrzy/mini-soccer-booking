<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Field;
use Illuminate\Support\Str;

class BookingTest extends TestCase
{
    use RefreshDatabase;

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

        // Step 3: Create a field with a UUID
        $field = Field::create([
            'id' => (string) Str::uuid(),
            'name' => 'Test Field',
            'description' => 'This is a test field',
        ]);

        // Step 4: Book the field
        $bookingResponse = $this->post('/bookings', [
            'field_id' => $field->id,
            'date' => '2024-07-01',
            'start_time' => '10:00',
            'end_time' => '12:00',
        ]);

        $bookingResponse->assertRedirect('/bookings');

        // Check for validation errors
        if ($bookingResponse->exception) {
            dd($bookingResponse->exception->validator->errors()->messages());
        }

        $this->assertDatabaseHas('bookings', [
            'user_id' => User::where('email', 'john@example.com')->first()->id,
            'field_id' => $field->id,
            'date' => '2024-07-01',
            'start_time' => '10:00',
            'end_time' => '12:00',
        ]);

        // Step 5: Attempt to book the same field at the same time (should fail)
        $duplicateBookingResponse = $this->post('/bookings', [
            'field_id' => $field->id,
            'date' => '2024-07-01',
            'start_time' => '11:00', // Overlaps with the previous booking
            'end_time' => '13:00',
        ]);

        $duplicateBookingResponse->assertSessionHasErrors(['msg' => 'The field is already booked for this time slot.']);
    }
}
