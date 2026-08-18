@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Posts</h1>
    <a href="{{ route('posts.create') }}" class="btn btn-primary">➕ Create New Post</a>
</div>

@if($posts->count() > 0)
<div class="row">
    @foreach($posts as $post)
    <div class="col-md-6 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">{{ $post->title }}</h5>
                <p class="card-text">{{ Str::limit($post->content, 150) }}</p>

                <div class="small text-muted mb-3">
                    <div>📝 Created by: <strong>{{ $post->creator->name ?? 'Unknown' }}</strong> at {{ $post->created_at->format('M d, Y H:i') }}</div>
                    @if($post->updater && $post->updater->id !== $post->creator->id)
                    <div>✏️ Updated by: <strong>{{ $post->updater->name ?? 'Unknown' }}</strong> at {{ $post->updated_at->format('M d, Y H:i') }}</div>
                    @elseif($post->created_at != $post->updated_at)
                    <div>✏️ Updated at: {{ $post->updated_at->format('M d, Y H:i') }}</div>
                    @endif
                </div>

                <div class="btn-group" role="group">

                    <a href="{{ route('posts.show', $post) }}"
                        class="btn btn-sm btn-info">
                        View
                    </a>

                    <a href="{{ route('posts.activity', $post) }}"
                        class="btn btn-sm btn-secondary">
                        Activity
                    </a>

                    <a href="{{ route('posts.edit', $post) }}"
                        class="btn btn-sm btn-warning">
                        Edit
                    </a>

                    <form action="{{ route('posts.destroy', $post) }}"
                        method="POST"
                        class="d-inline">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="btn btn-sm btn-danger"
                            onclick="return confirm('Are you sure you want to delete this post?')">
                            Delete
                        </button>

                    </form>

                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="alert alert-info">
    No posts found. <a href="{{ route('posts.create') }}">Create your first post!</a>
</div>
@endif
@endsection