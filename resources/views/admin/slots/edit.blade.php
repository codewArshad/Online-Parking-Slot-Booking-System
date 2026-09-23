@extends('layouts.app')

@section('title', 'Edit Slot')

@section('content')
    <h3 class="mb-4">Edit Parking Slot</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.slots.update', $slot) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Slot Number</label>
                    <input type="text" name="slot_number" value="{{ old('slot_number', $slot->slot_number) }}"
                           class="form-control @error('slot_number') is-invalid @enderror" required>
                    @error('slot_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" value="{{ old('location', $slot->location) }}"
                           class="form-control @error('location') is-invalid @enderror" required>
                    @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Vehicle Type</label>
                    <select name="vehicle_type" class="form-select @error('vehicle_type') is-invalid @enderror" required>
                        @foreach(['Car', 'Bike', 'Both'] as $type)
                            <option value="{{ $type }}" {{ old('vehicle_type', $slot->vehicle_type) === $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                    @error('vehicle_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Price (₹)</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $slot->price) }}"
                           class="form-control @error('price') is-invalid @enderror" required>
                    @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        @foreach(['Available', 'Booked'] as $status)
                            <option value="{{ $status }}" {{ old('status', $slot->status) === $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Slot</button>
                <a href="{{ route('admin.slots.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
