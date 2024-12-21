@extends('dashboard.layout')

@section('content')
    <div class="container my-4">
        <h1 class="h3">Edit Enrollment</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('enrollment.update', $enrollment->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="pending" {{ $enrollment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="enrolled" {{ $enrollment->status == 'enrolled' ? 'selected' : '' }}>Enrolled</option>
                    <option value="completed" {{ $enrollment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>


            <button type="submit" class="btn btn-success">Update Enrollment</button>
            <a href="{{ route('enrollment.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
