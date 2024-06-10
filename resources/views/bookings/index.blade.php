@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Book a Field</h2>
    <form action="/bookings" method="POST">
        @csrf
        <div class="form-group">
            <label for="field_id">Field ID</label>
            <input type="text" class="form-control" id="field_id" name="field_id" required>
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>
        <div class="form-group">
            <label for="start_time">Start Time</label>
            <input type="time" class="form-control" id="start_time" name="start_time" required>
        </div>
        <div class="form-group">
            <label for="end_time">End Time</label>
            <input type="time" class="form-control" id="end_time" name="end_time" required>
        </div>
        <button type="submit" class="btn btn-primary">Book</button>
    </form>
</div>
@endsection
