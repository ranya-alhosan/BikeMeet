@extends('dashboard.layout')

@section('content')
<div class="container">
    <h1>Contact Details</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">User: {{ $contact->name }}</h5>
            <p class="card-text">Email: {{ $contact->email }}</p>
            <p class="card-text">Phone: {{ $contact->subject }}</p>
            <p class="card-text">Message: {{ $contact->message }}</p>
        </div>
    </div>
    <a href="{{ route('contacts.index') }}" class="btn btn-secondary mt-3">Back to Contacts</a>
</div>
@endsection
