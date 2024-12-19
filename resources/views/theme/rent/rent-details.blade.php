@extends('theme.master')

@section('hero-title', 'Rental Details')
@section('rent-active', 'active')

@section('content')
    @section('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                @if(session('success'))
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route('rentals') }}';
                    }
                });
                @endif
            });
        </script>
    @endsection
<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <!-- Motorcycle Image -->
            <img src="{{ asset('storage/' . $rental->motorcycle->image) }}" class="img-fluid rounded shadow" alt="Motorcycle Image">
        </div>
        <div class="col-md-6">
            <!-- Rental Details -->
            <h3>{{ $rental->motorcycle->make }} {{ $rental->motorcycle->model }}</h3>
            <p><strong>User:</strong> {{ $rental->user->name }}</p>
            <p><strong>Price Per Day:</strong> ${{ number_format($rental->motorcycle->price_per_day, 2) }}</p>
            <p>
                <strong>Status:</strong>
                <span style="color: {{ $rental->status === 'available' ? '#198754' : '#dc3545' }}">
                    {{ ucfirst($rental->status) }}
                </span>
            </p>
            <p><strong>Rental Period:</strong>
                {{ \Carbon\Carbon::parse($rental->rental_start_date)->format('M d, Y') }}
                -
                {{ \Carbon\Carbon::parse($rental->rental_end_date)->format('M d, Y') }}
            </p>
            <p><strong>Description:</strong> {{ $rental->motorcycle->description }}</p>

            <!-- Action Buttons -->
            @if($rental->status === 'available' && $rental->motorcycle->user_id !== auth()->id())
                <form action="{{ route('rentals.proceed', $rental->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary mt-3">Proceed to Rent</button>
                </form>
            @else
                <p class="text-danger mt-3">Sorry, this motorcycle is not available for rent.</p>
            @endif

            <a href="{{ route('rentals.showRentals') }}" class="btn btn-secondary mt-3">Back to Rentals</a>
        </div>
    </div>
</div>



@endsection

