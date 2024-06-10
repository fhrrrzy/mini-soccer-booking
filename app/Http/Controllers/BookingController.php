<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        return view('bookings.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'field_id' => 'required|uuid',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $existingBooking = Booking::where('field_id', $request->field_id)
            ->where('date', $request->date)
            ->where(function($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                      ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
            })
            ->exists();

        if ($existingBooking) {
            return back()->withErrors(['msg' => 'The field is already booked for this time slot.']);
        }

        Booking::create([
            'field_id' => $request->field_id,
            'user_id' => Auth::id(),
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return back()->with('success', 'Booking successful!');
    }
}
