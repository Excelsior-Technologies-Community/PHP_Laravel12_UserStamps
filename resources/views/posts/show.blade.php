@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h1>{{ $post->title }}</h1>
        <p class="text-muted mb-0">
            Post #{{ $post->id }}
        </p>
    </div>

    <div>
        <a href="{{ route('posts.activity', $post) }}"
           class="btn btn-info">
            📋 Activity History
        </a>

        <a href="{{ route('posts.index') }}"
           class="btn btn-secondary">
            ← Back
        </a>
    </div>

</div>

<div class="card shadow mb-4">

    <div class="card-body">

        <h5 class="card-title">Post Content</h5>

        <p class="card-text" style="white-space: pre-line;">
            {{ $post->content }}
        </p>

    </div>

</div>


{{-- UserStamp Audit Information --}}

<div class="card shadow">

    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            🔍 UserStamp Audit Information
        </h5>
    </div>

    <div class="card-body">

        <div class="row">

            {{-- Creation Information --}}

            <div class="col-md-4">

                <div class="border rounded p-3 h-100">

                    <h6 class="text-success">
                        🟢 Creation Information
                    </h6>

                    <hr>

                    <p class="mb-2">
                        <strong>Created By:</strong><br>

                        {{ $post->creator->name ?? 'Unknown' }}
                    </p>

                    <p class="mb-0">
                        <strong>Created At:</strong><br>

                        {{ $post->created_at->format('F j, Y g:i A') }}
                    </p>

                </div>

            </div>


            {{-- Update Information --}}

            <div class="col-md-4">

                <div class="border rounded p-3 h-100">

                    <h6 class="text-primary">
                        🔵 Update Information
                    </h6>

                    <hr>

                    <p class="mb-2">
                        <strong>Updated By:</strong><br>

                        {{ $post->updater->name ?? 'Unknown' }}
                    </p>

                    <p class="mb-0">
                        <strong>Updated At:</strong><br>

                        {{ $post->updated_at->format('F j, Y g:i A') }}
                    </p>

                </div>

            </div>


            {{-- Delete Information --}}

            <div class="col-md-4">

                <div class="border rounded p-3 h-100">

                    <h6 class="text-danger">
                        🔴 Delete Information
                    </h6>

                    <hr>

                    <p class="mb-2">
                        <strong>Deleted By:</strong><br>

                        {{ $post->deleter->name ?? 'Not Deleted' }}
                    </p>

                    <p class="mb-0">

                        <strong>Deleted At:</strong><br>

                        @if($post->deleted_at)

                            {{ $post->deleted_at->format('F j, Y g:i A') }}

                        @else

                            Not Deleted

                        @endif

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection