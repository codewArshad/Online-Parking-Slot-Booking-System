@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="p-5 mb-4 bg-white rounded-3 shadow-sm text-center">
        <h1 class="display-6 fw-bold">Online Parking Slot Booking System</h1>
        <p class="fs-5 text-muted">Book your parking slot quickly and easily.</p>

        @guest
            <a href="{{ route('login') }}" class="btn btn-primary me-2">Login</a>
            <a href="{{ route('register') }}" class="btn btn-outline-primary">Register</a>
        @endguest

        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
            @else
                <a href="{{ route('user.dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
            @endif
        @endauth
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-3">How it works</h5>
            <ol class="mb-0">
                <li>Register / Login</li>
                <li>Select an available parking slot</li>
                <li>Enter booking details</li>
                <li>Confirm your booking</li>
                <li>View or cancel your booking anytime</li>
            </ol>
        </div>
    </div>
@endsection
