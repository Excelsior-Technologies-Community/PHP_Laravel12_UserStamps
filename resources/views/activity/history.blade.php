@extends('layouts.app')

@section('content')

<style>
    .activity-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
        border-radius: 20px;
        padding: 28px;
        color: #fff;
        margin-bottom: 24px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, .15);
    }

    .activity-header h1 {
        font-weight: 700;
        margin-bottom: 5px;
    }

    .activity-header p {
        color: rgba(255, 255, 255, .72);
        margin-bottom: 0;
    }

    .activity-header .btn {
        border-radius: 10px;
        font-weight: 600;
        padding: 9px 16px;
    }

    .filter-card,
    .activity-card {
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
        color: #0f172a;
        font-weight: 700;
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

    .activity-card .card-body {
        padding: 0;
    }

    .activity-table {
        margin-bottom: 0;
    }

    .activity-table thead th {
        background: #f8fafc;
        color: #475569;
        border-bottom: 1px solid #e2e8f0;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .4px;
        padding: 15px;
        white-space: nowrap;
    }

    .activity-table tbody td {
        padding: 16px 15px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13px;
        color: #475569;
    }

    .activity-table tbody tr:hover {
        background: #f8fafc;
    }

    .action-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
    }

    .action-created {
        background: #dcfce7;
        color: #15803d;
    }

    .action-updated {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .action-deleted {
        background: #fee2e2;
        color: #b91c1c;
    }

    .action-restored {
        background: #ccfbf1;
        color: #0f766e;
    }

    .action-force-deleted {
        background: #e2e8f0;
        color: #334155;
    }

    .action-default {
        background: #f1f5f9;
        color: #475569;
    }

    .post-link {
        color: #1d4ed8;
        text-decoration: none;
        font-weight: 600;
    }

    .post-link:hover {
        text-decoration: underline;
    }

    .user-name {
        color: #0f172a;
        font-weight: 600;
    }

    .activity-date {
        color: #64748b;
        white-space: nowrap;
    }

    .pagination-box {
        padding: 18px 20px;
        border-top: 1px solid #eef2f7;
        background: #fff;
    }

    .results-text {
        color: #64748b;
        font-size: 13px;
    }

    .empty-state {
        padding: 60px 25px;
        text-align: center;
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

        .activity-header {
            padding: 20px;
        }

        .activity-header .btn {
            width: 100%;
            margin-top: 15px;
        }

        .pagination-box {
            overflow-x: auto;
        }
    }
</style>


{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}

<div class="activity-header">

    <div class="row align-items-center">

        <div class="col-lg-8">

            <div class="small text-uppercase fw-semibold mb-1"
                style="color: rgba(255,255,255,.65);">

                UserStamp Management

            </div>

            <h1>
                Activity History
            </h1>

            <p>
                Monitor who created, updated, deleted or restored posts.
            </p>

        </div>

        <div class="col-lg-4 text-lg-end">

            <a href="{{ route('dashboard') }}"
                class="btn btn-light">

                Dashboard

            </a>

            <a href="{{ route('posts.index') }}"
                class="btn btn-primary">

                Posts

            </a>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- FILTERS --}}
{{-- ========================================================= --}}

<div class="card filter-card mb-4">

    <div class="card-header">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <div class="filter-title">
                    Search & Filters
                </div>

                <small class="text-muted">
                    Filter your UserStamp activity records
                </small>

            </div>

            <span class="badge rounded-pill text-bg-light">
                Audit Logs
            </span>

        </div>

    </div>


    <div class="card-body">

        <form method="GET"
            action="{{ route('activity.history') }}">

            <div class="row g-3">

                {{-- Search --}}
                <div class="col-lg-3 col-md-6">

                    <label class="form-label">
                        Search
                    </label>

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        value="{{ request('search') }}"
                        placeholder="Post, user or description...">

                </div>


                {{-- Action --}}
                <div class="col-lg-2 col-md-6">

                    <label class="form-label">
                        Action
                    </label>

                    <select
                        name="action"
                        class="form-select">

                        <option value="">
                            All Actions
                        </option>

                        @foreach([
                        'created',
                        'updated',
                        'deleted',
                        'restored',
                        'force_deleted'
                        ] as $action)

                        <option
                            value="{{ $action }}"
                            @selected(request('action')===$action)>

                            {{ ucfirst(
                                    str_replace(
                                        '_',
                                        ' ',
                                        $action
                                    )
                                ) }}

                        </option>

                        @endforeach

                    </select>

                </div>


                {{-- User --}}
                <div class="col-lg-2 col-md-6">

                    <label class="form-label">
                        User
                    </label>

                    <select
                        name="user_id"
                        class="form-select">

                        <option value="">
                            All Users
                        </option>

                        @foreach($users as $user)

                        <option
                            value="{{ $user->id }}"
                            @selected(request('user_id')==$user->id)
                            >

                            {{ $user->name }}

                        </option>

                        @endforeach

                    </select>

                </div>


                {{-- Date From --}}
                <div class="col-lg-2 col-md-6">

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
                <div class="col-lg-2 col-md-6">

                    <label class="form-label">
                        Date To
                    </label>

                    <input
                        type="date"
                        name="date_to"
                        class="form-control"
                        value="{{ request('date_to') }}">

                </div>


                {{-- Per Page --}}
                <div class="col-lg-1 col-md-6">

                    <label class="form-label">
                        Rows
                    </label>

                    <select
                        name="per_page"
                        class="form-select">

                        @foreach([10, 25, 50, 100] as $number)

                        <option
                            value="{{ $number }}"
                            @selected(request('per_page', 10)==$number)>

                            {{ $number }}

                        </option>

                        @endforeach

                    </select>

                </div>


                {{-- Buttons --}}
                <div class="col-12">

                    <div class="filter-actions d-flex gap-2 flex-wrap">

                        <button
                            type="submit"
                            class="btn btn-primary">

                            🔍 Search

                        </button>

                        <a
                            href="{{ route('activity.history') }}"
                            class="btn btn-outline-secondary">

                            ↻ Reset

                        </a>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>


{{-- ========================================================= --}}
{{-- ACTIVITY TABLE --}}
{{-- ========================================================= --}}

<div class="card activity-card">

    <div class="card-body">

        @if($activities->count() > 0)

        <div class="table-responsive">

            <table class="table activity-table">

                <thead>

                    <tr>

                        <th>
                            #
                        </th>

                        <th>
                            Action
                        </th>

                        <th>
                            Post
                        </th>

                        <th>
                            User
                        </th>

                        <th>
                            Description
                        </th>

                        <th>
                            Date & Time
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($activities as $activity)

                    @php

                    $actionClass = match($activity->action) {

                    'created'
                    => 'action-created',

                    'updated'
                    => 'action-updated',

                    'deleted'
                    => 'action-deleted',

                    'restored'
                    => 'action-restored',

                    'force_deleted'
                    => 'action-force-deleted',

                    default
                    => 'action-default',

                    };

                    @endphp

                    <tr>

                        {{-- ID --}}
                        <td>

                            <span class="text-muted">
                                #{{ $activity->id }}
                            </span>

                        </td>


                        {{-- Action --}}
                        <td>

                            <span
                                class="action-badge {{ $actionClass }}">

                                {{ ucfirst(
                                            str_replace(
                                                '_',
                                                ' ',
                                                $activity->action
                                            )
                                        ) }}

                            </span>

                        </td>


                        {{-- Post --}}
                        <td>

                            @if($activity->post)

                            <a
                                href="{{ route(
                                                'posts.show',
                                                $activity->post
                                            ) }}"
                                class="post-link">

                                {{ $activity->post->title }}

                            </a>

                            @else

                            <span class="text-muted">
                                Post deleted
                            </span>

                            @endif

                        </td>


                        {{-- User --}}
                        <td>

                            <span class="user-name">

                                {{ $activity->user->name ?? 'Unknown' }}

                            </span>

                        </td>


                        {{-- Description --}}
                        <td>

                            {{ $activity->description }}

                        </td>


                        {{-- Date --}}
                        <td>

                            <span class="activity-date">

                                {{ optional(
                                            $activity->created_at
                                        )->format(
                                            'M d, Y h:i A'
                                        ) }}

                            </span>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        {{-- ================================================= --}}
        {{-- PAGINATION --}}
        {{-- ================================================= --}}

        <div class="pagination-box">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div class="results-text">

                    Showing

                    <strong>
                        {{ $activities->firstItem() ?? 0 }}
                    </strong>

                    to

                    <strong>
                        {{ $activities->lastItem() ?? 0 }}
                    </strong>

                    of

                    <strong>
                        {{ $activities->total() }}
                    </strong>

                    activities

                </div>


                <div>

                    {{ $activities
                            ->onEachSide(1)
                            ->links() }}

                </div>

            </div>

        </div>

        @else

        {{-- EMPTY STATE --}}

        <div class="empty-state">

            <div class="empty-icon">
                📋
            </div>

            <h4 class="fw-bold">
                No Activity Found
            </h4>

            <p class="text-muted mb-4">

                There are no activity records matching
                your current filters.

            </p>

            <a
                href="{{ route('activity.history') }}"
                class="btn btn-primary">

                Clear Filters

            </a>

        </div>

        @endif

    </div>

</div>

@endsection