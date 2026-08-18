@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1>Activity History</h1>
        <p class="text-muted mb-0">
            Post: <strong>{{ $post->title }}</strong>
        </p>
    </div>

    <a href="{{ route('posts.show', $post) }}" class="btn btn-secondary">
        ← Back to Post
    </a>
</div>

@if($activities->count() > 0)

    <div class="card shadow">
        <div class="card-body">

            <div class="list-group">

                @foreach($activities as $activity)

                    @php
                        $badgeClass = match($activity->action) {
                            'created' => 'bg-success',
                            'updated' => 'bg-primary',
                            'deleted' => 'bg-danger',
                            'restored' => 'bg-success',
                            'force_deleted' => 'bg-dark',
                            default => 'bg-secondary',
                        };

                        $icon = match($activity->action) {
                            'created' => '🟢',
                            'updated' => '🔵',
                            'deleted' => '🔴',
                            'restored' => '♻️',
                            'force_deleted' => '⚫',
                            default => '📌',
                        };
                    @endphp

                    <div class="list-group-item py-3">

                        <div class="d-flex justify-content-between align-items-start">

                            <div>

                                <div class="mb-2">
                                    <span class="fs-5">
                                        {{ $icon }}
                                    </span>

                                    <span class="badge {{ $badgeClass }}">
                                        {{ ucfirst(str_replace('_', ' ', $activity->action)) }}
                                    </span>
                                </div>

                                <h6 class="mb-1">
                                    {{ $activity->description }}
                                </h6>

                                <p class="mb-0 text-muted">
                                    Performed by:
                                    <strong>
                                        {{ $activity->user->name ?? 'Unknown User' }}
                                    </strong>
                                </p>

                            </div>

                            <small class="text-muted">
                                {{ $activity->created_at->format('M d, Y h:i A') }}
                            </small>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>
    </div>

@else

    <div class="alert alert-info">
        No activity has been recorded for this post yet.
    </div>

@endif

@endsection