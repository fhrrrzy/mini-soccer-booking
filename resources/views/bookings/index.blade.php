@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-6 mb-4">
            <img src="{{ asset('img/soccer.jpg') }}" class="img-fluid rounded" alt="Soccer field">
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title">Book a Field</h1>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="field_id" class="form-label">Field</label>
                            <select name="field_id" id="field_id" class="form-select">
                                @foreach($fields as $field)
                                    <option value="{{ $field->id }}">{{ $field->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" name="date" id="date" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="start_time" class="form-label">Start Time</label>
                            <input type="time" name="start_time" id="start_time" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="end_time" class="form-label">End Time</label>
                            <input type="time" name="end_time" id="end_time" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary">Book</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-5">
        <div class="card-body">
            <h1 class="card-title">Current Bookings</h1>

            <div class="row">
                @foreach($bookings as $booking)
                    <div class="col-md-4 mb-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5 class="card-title">{{ $booking->field->name }}</h5>
                                <p class="card-text">{{ $booking->date }}</p>
                                <p class="card-text">{{ $booking->start_time }} - {{ $booking->end_time }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
