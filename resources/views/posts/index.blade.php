@extends('layouts.app')

@section('content')

<style>
    .page-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
        border-radius: 20px;
        padding: 28px;
        color: #fff;
        margin-bottom: 24px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, .15);
    }

    .page-header h1 {
        font-weight: 700;
        letter-spacing: -.5px;
    }

    .page-header p {
        color: rgba(255, 255, 255, .75);
    }

    .header-actions .btn {
        border-radius: 10px;
        padding: 9px 16px;
        font-weight: 600;
    }

    .filter-card {
        border: 0;
        border-radius: 18px;
        box-shadow: 0 6px 25px rgba(15, 23, 42, .07);
        overflow: hidden;
    }

    .filter-card .card-header {
        background: #fff;
        border-bottom: 1px solid #eef2f7;
        padding: 18px 22px;
    }

    .filter-card .card-body {
        padding: 22px;
    }

    .filter-title {
        font-weight: 700;
        color: #0f172a;
    }

    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 7px;
    }

    .form-control,
    .form-select {
        min-height: 44px;
        border-radius: 10px;
        border: 1px solid #dbe2ea;
        font-size: 14px;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 .2rem rgba(59, 130, 246, .10);
    }

    .filter-actions .btn {
        min-height: 44px;
        border-radius: 10px;
        font-weight: 600;
        padding: 0 18px;
    }

    .stat-card {
        border: 0;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 6px 25px rgba(15, 23, 42, .07);
        transition: .2s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(15, 23, 42, .11);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
    }

    .stat-icon.blue {
        background: #eff6ff;
        color: #2563eb;
    }

    .stat-icon.green {
        background: #ecfdf5;
        color: #059669;
    }

    .stat-icon.dark {
        background: #f1f5f9;
        color: #334155;
    }

    .stat-label {
        color: #64748b;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .stat-number {
        color: #0f172a;
        font-size: 27px;
        font-weight: 750;
        line-height: 1;
    }

    .post-card {
        border: 0;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 6px 25px rgba(15, 23, 42, .07);
        transition: .2s ease;
        overflow: hidden;
    }

    .post-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 35px rgba(15, 23, 42, .12);
    }

    .post-card .card-body {
        padding: 23px;
    }

    .post-title {
        font-size: 19px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 10px;
    }

    .post-content {
        color: #64748b;
        line-height: 1.7;
        font-size: 14px;
        min-height: 48px;
    }

    .stamp-box {
        background: #f8fafc;
        border-radius: 12px;
        padding: 13px 14px;
        margin-top: 17px;
        border: 1px solid #eef2f7;
    }

    .stamp-row {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        color: #64748b;
    }

    .stamp-row+.stamp-row {
        margin-top: 9px;
    }

    .stamp-user {
        color: #334155;
        font-weight: 600;
    }

    .stamp-date {
        margin-left: auto;
        color: #94a3b8;
        white-space: nowrap;
    }

    .action-buttons {
        display: flex;
        gap: 7px;
        margin-top: 19px;
        flex-wrap: wrap;
    }

    .action-buttons .btn {
        border-radius: 9px;
        font-size: 12px;
        font-weight: 600;
        padding: 7px 11px;
    }

    .results-bar {
        background: #fff;
        border-radius: 16px;
        padding: 15px 18px;
        box-shadow: 0 5px 20px rgba(15, 23, 42, .05);
        margin-bottom: 18px;
    }

    .results-count {
        color: #475569;
        font-size: 13px;
        font-weight: 600;
    }

    .pagination-wrapper {
        background: #fff;
        border-radius: 16px;
        padding: 16px 20px;
        margin-top: 8px;
        box-shadow: 0 5px 20px rgba(15, 23, 42, .05);
    }

    .empty-state {
        background: #fff;
        border-radius: 18px;
        padding: 60px 25px;
        text-align: center;
        box-shadow: 0 6px 25px rgba(15, 23, 42, .06);
    }

    .empty-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 18px;
        border-radius: 20px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
    }

    @media (max-width: 767px) {

        .page-header {
            padding: 20px;
        }

        .header-actions {
            margin-top: 18px;
        }

        .header-actions .btn {
            width: 100%;
            margin-bottom: 8px;
        }

        .stamp-date {
            display: none;
        }

        .results-bar {
            text-align: center;
        }

        .pagination-wrapper {
            overflow-x: auto;
        }
    }
</style>


{{-- ========================================================= --}}
{{-- PAGE HEADER --}}
{{-- ========================================================= --}}

<div class="page-header">

    <div class="row align-items-center">

        <div class="col-lg-7">

            <div class="d-flex align-items-center gap-3">

                <div>
                    <div class="small text-uppercase fw-semibold mb-1"
                        style="color: rgba(255,255,255,.65);">
                        UserStamp Management
                    </div>

                    <h1 class="mb-1">
                        Posts
                    </h1>

                    <p class="mb-0">
                        Manage your posts and monitor who created or updated them.
                    </p>
                </div>

            </div>

        </div>

        <div class="col-lg-5">

            <div class="header-actions d-flex justify-content-lg-end gap-2">

                <a href="{{ route('dashboard') }}"
                    class="btn btn-light">

                    Dashboard

                </a>

                <a href="{{ route('posts.create') }}"
                    class="btn btn-primary bg-white text-primary border-0">

                    + Create Post

                </a>

            </div>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- SEARCH & FILTERS --}}
{{-- ========================================================= --}}

<div class="card filter-card mb-4">

    <div class="card-header">


        {{-- ========================================================= --}}
        {{-- STATISTICS --}}
        {{-- ========================================================= --}}

        <div class="row g-3 mb-4">

            {{-- Total --}}
            <div class="col-lg-4 col-md-6">

                <div class="card stat-card h-100">

                    <div class="card-body">

                        <div class="d-flex align-items-center gap-3">

                            <div class="stat-icon blue">
                                📄
                            </div>

                            <div>

                                <div class="stat-label">
                                    Total Matching Posts
                                </div>

                                <div class="stat-number">
                                    {{ $posts->total() }}
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Current --}}
            <div class="col-lg-4 col-md-6">

                <div class="card stat-card h-100">

                    <div class="card-body">

                        <div class="d-flex align-items-center gap-3">

                            <div class="stat-icon green">
                                ✓
                            </div>

                            <div>

                                <div class="stat-label">
                                    Records On This Page
                                </div>

                                <div class="stat-number">
                                    {{ $posts->count() }}
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Page --}}
            <div class="col-lg-4 col-md-12">

                <div class="card stat-card h-100">

                    <div class="card-body">

                        <div class="d-flex align-items-center gap-3">

                            <div class="stat-icon dark">
                                #
                            </div>

                            <div>

                                <div class="stat-label">
                                    Current Page
                                </div>

                                <div class="stat-number">

                                    {{ $posts->currentPage() }}

                                    <span class="fs-6 text-muted fw-normal">
                                        / {{ $posts->lastPage() }}
                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="d-flex align-items-center justify-content-between">

            <div>

                <div class="filter-title">
                    Search & Filters
                </div>

                <small class="text-muted">
                    Find posts using multiple criteria
                </small>

            </div>



            <span class="badge rounded-pill text-bg-light">
                Advanced Search
            </span>

        </div>

    </div>



    <div class="card-body">

        <form method="GET"
            action="{{ route('posts.index') }}">

            <div class="row g-3">

                {{-- Search --}}
                <div class="col-lg-4 col-md-6">

                    <label class="form-label">
                        Search
                    </label>

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        value="{{ request('search') }}"
                        placeholder="Search ID, title or content...">

                </div>


                {{-- Created By --}}
                <div class="col-lg-2 col-md-6">

                    <label class="form-label">
                        Created By
                    </label>

                    <select name="created_by"
                        class="form-select">

                        <option value="">
                            All Users
                        </option>

                        @foreach($users as $user)

                        <option
                            value="{{ $user->id }}"
                            @selected(request('created_by')==$user->id)
                            >
                            {{ $user->name }}
                        </option>

                        @endforeach

                    </select>

                </div>


                {{-- Updated By --}}
                <div class="col-lg-2 col-md-6">

                    <label class="form-label">
                        Updated By
                    </label>

                    <select name="updated_by"
                        class="form-select">

                        <option value="">
                            All Users
                        </option>

                        @foreach($users as $user)

                        <option
                            value="{{ $user->id }}"
                            @selected(request('updated_by')==$user->id)
                            >
                            {{ $user->name }}
                        </option>

                        @endforeach

                    </select>

                </div>


                {{-- Sort --}}
                <div class="col-lg-2 col-md-6">

                    <label class="form-label">
                        Sort By
                    </label>

                    <select name="sort"
                        class="form-select">

                        <option
                            value="latest"
                            @selected(request('sort', 'latest' )=='latest' )>
                            Latest
                        </option>

                        <option
                            value="oldest"
                            @selected(request('sort')=='oldest' )>
                            Oldest
                        </option>

                        <option
                            value="title_asc"
                            @selected(request('sort')=='title_asc' )>
                            Title A-Z
                        </option>

                        <option
                            value="title_desc"
                            @selected(request('sort')=='title_desc' )>
                            Title Z-A
                        </option>

                    </select>

                </div>


                {{-- Per Page --}}
                <div class="col-lg-2 col-md-6">

                    <label class="form-label">
                        Records
                    </label>

                    <select name="per_page"
                        class="form-select">

                        @foreach([5,6, 10, 25, 50] as $number)

                        <option
                            value="{{ $number }}"
                            @selected(request('per_page', 5)==$number)>
                            {{ $number }} / page
                        </option>

                        @endforeach

                    </select>

                </div>


                {{-- Date From --}}
                <div class="col-lg-3 col-md-6">

                    <label class="form-label">
                        Date From
                    </label>

                    <input
                        type="date"
                        name="date_from"
                        class="form-control"
                        value="{{ request('date_from') }}">

                </div>


                {{-- Date To --}}
                <div class="col-lg-3 col-md-6">

                    <label class="form-label">
                        Date To
                    </label>

                    <input
                        type="date"
                        name="date_to"
                        class="form-control"
                        value="{{ request('date_to') }}">

                </div>


                {{-- Buttons --}}
                <div class="col-lg-6 col-md-12">

                    <label class="form-label d-block">
                        Actions
                    </label>

                    <div class="filter-actions d-flex gap-2 flex-wrap">

                        <button
                            type="submit"
                            class="btn btn-primary">

                            🔍 Search

                        </button>

                        <a
                            href="{{ route('posts.index') }}"
                            class="btn btn-outline-secondary">

                            ↻ Reset

                        </a>

                        <a
                            href="{{ route('posts.export', request()->query()) }}"
                            class="btn btn-success">

                            ↓ Export CSV

                        </a>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>




{{-- ========================================================= --}}
{{-- RESULTS BAR --}}
{{-- ========================================================= --}}

@if($posts->count() > 0)

<div class="results-bar">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

        <div class="results-count">

            Showing

            <strong>
                {{ $posts->firstItem() }}
            </strong>

            to

            <strong>
                {{ $posts->lastItem() }}
            </strong>

            of

            <strong>
                {{ $posts->total() }}
            </strong>

            posts

        </div>

        @if(request()->hasAny([
        'search',
        'created_by',
        'updated_by',
        'date_from',
        'date_to'
        ]))

        <span class="badge rounded-pill bg-primary-subtle text-primary">

            Filters Applied

        </span>

        @endif

    </div>

</div>


{{-- ========================================================= --}}
{{-- POSTS --}}
{{-- ========================================================= --}}

<div class="row g-4">

    @foreach($posts as $post)

    <div class="col-xl-4 col-lg-6">

        <div class="card post-card h-100">

            <div class="card-body d-flex flex-column">

                {{-- Title --}}
                <div>

                    <h5 class="post-title">

                        {{ $post->title }}

                    </h5>

                    <p class="post-content mb-0">

                        {{ Str::limit(
                                $post->content,
                                150
                            ) }}

                    </p>

                </div>


                {{-- UserStamp --}}
                <div class="stamp-box">

                    <div class="stamp-row">

                        <span>
                            ✍️
                        </span>

                        <span>
                            Created by
                        </span>

                        <span class="stamp-user">

                            {{ $post->creator->name ?? 'Unknown' }}

                        </span>

                        <span class="stamp-date">

                            {{ optional($post->created_at)
                                    ->format('M d, Y') }}

                        </span>

                    </div>


                    <div class="stamp-row">

                        <span>
                            ✏️
                        </span>

                        <span>
                            Updated by
                        </span>

                        <span class="stamp-user">

                            {{ $post->updater->name ?? 'Unknown' }}

                        </span>

                        <span class="stamp-date">

                            {{ optional($post->updated_at)
                                    ->format('M d, Y') }}

                        </span>

                    </div>

                </div>


                {{-- Actions --}}
                <div class="action-buttons mt-auto">

                    <a
                        href="{{ route('posts.show', $post) }}"
                        class="btn btn-info text-white">

                        View

                    </a>

                    <a
                        href="{{ route(
                                'posts.activity',
                                $post->id
                            ) }}"
                        class="btn btn-secondary">

                        Activity

                    </a>

                    <a
                        href="{{ route(
                                'posts.edit',
                                $post
                            ) }}"
                        class="btn btn-warning">

                        Edit

                    </a>

                    <form
                        action="{{ route(
                                'posts.destroy',
                                $post
                            ) }}"
                        method="POST"
                        class="d-inline">

                        @csrf

                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn btn-danger"
                            onclick="return confirm(
                                    'Are you sure you want to delete this post?'
                                )">

                            Delete

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

    @endforeach

</div>


{{-- ========================================================= --}}
{{-- PAGINATION --}}
{{-- ========================================================= --}}

<div class="pagination-wrapper">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

        <div class="text-muted small">

            Page

            <strong>
                {{ $posts->currentPage() }}
            </strong>

            of

            <strong>
                {{ $posts->lastPage() }}
            </strong>

        </div>

        <div>

            {{ $posts->onEachSide(1)->links() }}

        </div>

    </div>

</div>


@else

{{-- ========================================================= --}}
{{-- EMPTY STATE --}}
{{-- ========================================================= --}}

<div class="empty-state">

    <div class="empty-icon">
        🔍
    </div>

    <h4 class="fw-bold">
        No Posts Found
    </h4>

    <p class="text-muted mb-4">

        We couldn't find any posts matching your current
        search or filters.

    </p>

    <a
        href="{{ route('posts.index') }}"
        class="btn btn-primary">

        Clear Filters

    </a>

</div>

@endif

@endsection