@foreach($newsletters as $newsletter)
    <div class="col">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title text-primary fw-bold">{{ $newsletter->title }}</h5>
                <p class="card-text text-muted">{{ Str::limit($newsletter->content, 100) }}</p>
                <p class="text-muted small mb-3">
                    <i class="fas fa-user"></i>
                    <strong>Owner:</strong> {{ $newsletter->user->name ?? 'Unknown' }}
                    <i class="fas fa-clock"></i>
                    <strong>Posted:</strong> {{ $newsletter->created_at->diffForHumans() }}
                </p>
            </div>
        </div>
    </div>
@endforeach
