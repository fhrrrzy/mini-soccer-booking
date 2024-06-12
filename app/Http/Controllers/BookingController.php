<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Field;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function index()
    {
        $fields = Field::all();
        $bookings = Booking::with('field')->get();

        return view('bookings.index', compact('fields', 'bookings'));
    }

    public function store(Request $request)
    {
        Log::info('Booking request received', $request->all());

        $validated = $request->validate([
            'field_id' => 'required|uuid',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $existingBooking = Booking::where('field_id', $validated['field_id'])
            ->where('date', $validated['date'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                      ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']]);
            })
            ->exists();

        if ($existingBooking) {
            Log::error('Booking conflict detected');
            return back()->withErrors(['msg' => 'The field is already booked for this time slot.']);
        }

        Booking::create([
            'field_id' => $validated['field_id'],
            'user_id' => Auth::id(),
            'date' => $validated['date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
        ]);

        Log::info('Booking created successfully');
        return redirect('/bookings')->with('success', 'Booking successful!');
    }
}
