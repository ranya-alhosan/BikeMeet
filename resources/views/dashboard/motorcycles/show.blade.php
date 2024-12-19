@extends('dashboard.layout')

@section('content')
    <div class="container">
        <h1>{{ $motorcycle->name }}</h1>
        <p><strong>Model:</strong> {{ $motorcycle->model }}</p>
        <p><strong>Year:</strong> {{ $motorcycle->year }}</p>
        <p><strong>Description:</strong> {{ $motorcycle->description }}</p>
        <a href="{{ route('motorcycles.edit', $motorcycle->id) }}" class="btn btn-warning">Edit</a>
    </div>
@endsection
