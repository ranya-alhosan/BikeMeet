@extends('dashboard.layout')

@section('content')
    <div class="container">
        <h1>Newsletters</h1>
        <a href="{{ route('newsletters.create') }}" class="btn btn-primary mb-3">Create New Newsletter</a>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Title</th>
                <th>Owner</th> <!-- New column for the owner -->
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($newsletters as $newsletter)
                <tr>
                    <td>{{ $newsletter->title }}</td>
                    <td>{{ $newsletter->user->name }}</td> <!-- Display the owner's name -->
                    <td>
                        <a href="{{ route('newsletters.show', $newsletter->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('DashNewsletters.edit', $newsletter->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('DashNewsletters.destroy', $newsletter->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this newsletter?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
