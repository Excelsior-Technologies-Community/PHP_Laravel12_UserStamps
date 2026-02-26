@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Create New Post</h1>
    <a href="{{ route('posts.index') }}" class="btn btn-secondary">← Back</a>
</div>

<div class="card shadow">
    <div class="card-body">
        <form action="{{ route('posts.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" 
                       class="form-control @error('title') is-invalid @enderror" 
                       id="title" 
                       name="title" 
                       value="{{ old('title') }}" 
                       required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control @error('content') is-invalid @enderror" 
                          id="content" 
                          name="content" 
                          rows="6" 
                          required>{{ old('content') }}</textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Create Post</button>
            </div>
        </form>
    </div>
</div>
@endsection