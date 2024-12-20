@if($events->isEmpty())
    <p>No events available at the moment.</p>
@else
    <div class="row">
        @foreach($events as $event)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $event->name }}</h5>
                        <p class="card-text">
                            <strong>Description:</strong> {{ Str::limit($event->description, 100) }}<br>
                            <strong>Location:</strong> {{ $event->location }}<br>
                            <strong>Start Date:</strong> {{ $event->start_date->format('F j, Y, g:i a') }}<br>
                            <strong>End Date:</strong> {{ $event->end_date->format('F j, Y, g:i a') }}<br>
                            <strong>Fee:</strong> ${{ number_format($event->fee, 2) }}<br>
                            <strong>Organizer:</strong> {{ $event->user->name ?? 'Unknown' }}<br>
                            @if($event->status === 'upcoming')
                                <strong>Status:</strong>
                                <span class="text-success">Active</span>
                            @else
                                <span class="text-danger">See you soon</span>
                            @endif
                        </p>
                        <a href="{{ route('events.showEventDetails', $event->id) }}" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
