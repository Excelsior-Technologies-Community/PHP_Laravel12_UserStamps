@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Trashed Posts</h1>
    <a href="{{ route('posts.index') }}" class="btn btn-secondary">← Back to Posts</a>
</div>

@if($posts->count() > 0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Deleted By</th>
                <th>Deleted At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->deleter->name ?? 'Unknown' }}</td>
                <td>{{ $post->deleted_at->format('M d, Y H:i') }}</td>
                <td>

                    <a href="{{ route('posts.activity', $post) }}"
                        class="btn btn-sm btn-info">
                        Activity
                    </a>

                    <form action="{{ route('posts.restore', $post->id) }}"
                        method="POST"
                        class="d-inline">

                        @csrf

                        <button type="submit"
                            class="btn btn-sm btn-success"
                            onclick="return confirm('Restore this post?')">
                            Restore
                        </button>

                    </form>

                    <form action="{{ route('posts.force-delete', $post->id) }}"
                        method="POST"
                        class="d-inline">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="btn btn-sm btn-danger"
                            onclick="return confirm('Permanently delete this post? This action cannot be undone.')">
                            Delete Permanently
                        </button>

                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="alert alert-info">
    No trashed posts found.
</div>
@endif
@endsection