@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h3 class="mb-4">Welcome, {{ auth()->user()->name }}</h3>

    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Parking Slots</h6>
                    <h3 class="text-success">{{ $availableSlots }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">My Active Bookings</h6>
                    <h3>{{ $myActiveBookings }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card text-center shadow-sm"><div class="card-body">
                <h6 class="text-muted">Total Bookings</h6><h3>{{ $myTotalBookings }}</h3>
            </div></div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card text-center shadow-sm"><div class="card-body">
                <h6 class="text-muted">Completed</h6><h3 class="text-secondary">{{ $myCompletedBookings }}</h3>
            </div></div>
        </div>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('user.book-slot') }}" class="btn btn-primary">Book a Slot</a>
        <a href="{{ route('user.bookings') }}" class="btn btn-outline-secondary">My Bookings</a>
    </div>
    <script>setTimeout(() => window.location.reload(), 60000);</script>
@endsection
