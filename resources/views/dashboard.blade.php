@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h1>UserStamps Dashboard</h1>

        <p class="text-muted">
            Posts, UserStamp and audit activity overview.
        </p>
    </div>

    <a
        href="{{ route('posts.index') }}"
        class="btn btn-primary">
        Manage Posts
    </a>

</div>

{{-- Main Statistics --}}
<div class="row g-4 mb-4">

    <div class="col-md-3">

        <div class="card shadow-sm border-primary h-100">

            <div class="card-body">

                <h6 class="text-muted">
                    Total Posts
                </h6>

                <h2 class="text-primary">
                    {{ $totalPosts }}
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card shadow-sm border-danger h-100">

            <div class="card-body">

                <h6 class="text-muted">
                    Trashed Posts
                </h6>

                <h2 class="text-danger">
                    {{ $trashedPosts }}
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card shadow-sm border-success h-100">

            <div class="card-body">

                <h6 class="text-muted">
                    Total Activities
                </h6>

                <h2 class="text-success">
                    {{ $totalActivities }}
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card shadow-sm border-dark h-100">

            <div class="card-body">

                <h6 class="text-muted">
                    Active Users
                </h6>

                <h2>
                    {{ $activeUsers }}
                </h2>

            </div>

        </div>

    </div>

</div>

{{-- Activity Statistics --}}
<div class="row g-4 mb-4">

    <div class="col-md-3">

        <div class="card shadow-sm h-100">

            <div class="card-body">

                <h6 class="text-muted">
                    Created
                </h6>

                <h3 class="text-success">
                    {{ $createdActivities }}
                </h3>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card shadow-sm h-100">

            <div class="card-body">

                <h6 class="text-muted">
                    Updated
                </h6>

                <h3 class="text-primary">
                    {{ $updatedActivities }}
                </h3>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card shadow-sm h-100">

            <div class="card-body">

                <h6 class="text-muted">
                    Deleted
                </h6>

                <h3 class="text-danger">
                    {{ $deletedActivities }}
                </h3>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card shadow-sm h-100">

            <div class="card-body">

                <h6 class="text-muted">
                    Restored
                </h6>

                <h3 class="text-success">
                    {{ $restoredActivities }}
                </h3>

            </div>

        </div>

    </div>

</div>

{{-- Today --}}
<div class="card shadow-sm mb-4">

    <div class="card-body">

        <div class="row align-items-center">

            <div class="col-md-8">

                <h5 class="mb-1">
                    Today's Activity
                </h5>

                <p class="text-muted mb-0">
                    Number of UserStamp activities recorded today.
                </p>

            </div>

            <div class="col-md-4 text-md-end">

                <h2 class="mb-0">
                    {{ $todayActivities }}
                </h2>

            </div>

        </div>

    </div>

</div>

{{-- Recent Activity --}}
<div class="card shadow-sm">

    <div class="card-header d-flex justify-content-between">

        <strong>
            Recent Activity
        </strong>

        <a
            href="{{ route('activity.history') }}"
            class="btn btn-sm btn-dark">
            View All
        </a>

    </div>

    <div class="card-body p-0">

        @if($recentActivities->count())

        <div class="table-responsive">

            <table class="table table-hover mb-0">

                <thead>

                    <tr>
                        <th>Action</th>
                        <th>Post</th>
                        <th>User</th>
                        <th>Date</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($recentActivities as $activity)

                    <tr>

                        <td>

                            @php

                            $badge = match($activity->action) {

                            'created'
                            => 'bg-success',

                            'updated'
                            => 'bg-primary',

                            'deleted'
                            => 'bg-danger',

                            'restored'
                            => 'bg-success',

                            'force_deleted'
                            => 'bg-dark',

                            default
                            => 'bg-secondary',

                            };

                            @endphp

                            <span class="badge {{ $badge }}">

                                {{ ucfirst(
                                            str_replace(
                                                '_',
                                                ' ',
                                                $activity->action
                                            )
                                        ) }}

                            </span>

                        </td>

                        <td>

                            @if($activity->post)

                            {{ $activity->post->title }}

                            @else

                            Deleted Post

                            @endif

                        </td>

                        <td>
                            {{ $activity->user->name ?? 'Unknown' }}
                        </td>

                        <td>
                            {{ optional($activity->created_at)
                                        ->format('M d, Y h:i A') }}
                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        @else

        <div class="p-4 text-muted">

            No activity found.

        </div>

        @endif

    </div>

</div>

@endsection