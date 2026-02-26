@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>{{ $post->title }}</h1>
    <a href="{{ route('posts.index') }}" class="btn btn-secondary">← Back</a>
</div>

<div class="card shadow">
    <div class="card-body">
        <p class="card-text" style="white-space: pre-line;">{{ $post->content }}</p>
        
        <hr>
        
        <div class="row">
            <div class="col-md-6">
                <h6>Creation Info</h6>
                <p class="text-muted">
                    <strong>Created by:</strong> {{ $post->creator->name ?? 'Unknown' }}<br>
                    <strong>Created at:</strong> {{ $post->created_at->format('F j, Y g:i A') }}
                </p>
            </div>
            <div class="col-md-6">
                <h6>Last Update Info</h6>
                <p class="text-muted">
                    <strong>Last updated by:</strong> {{ $post->updater->name ?? 'Unknown' }}<br>
                    <strong>Last updated at:</strong> {{ $post->updated_at->format('F j, Y g:i A') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection