<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Laravel UserStamps Demo')
    </title>

    {{-- Bootstrap --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet">


    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1e3a8a;
            --dark: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
            --background: #f8fafc;
        }


        /* =====================================================
           GLOBAL
        ===================================================== */

        body {
            background: var(--background);
            color: #334155;
            font-family:
                Inter,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;
            min-height: 100vh;
        }


        /* =====================================================
           NAVBAR
        ===================================================== */

        .main-navbar {
            background:
                linear-gradient(135deg,
                    #0f172a 0%,
                    #172554 55%,
                    #1e3a8a 100%);

            box-shadow:
                0 5px 20px rgba(15, 23, 42, .15);

            padding: 12px 0;

            position: sticky;
            top: 0;

            z-index: 1000;
        }


        .navbar-brand {
            font-weight: 750;
            font-size: 18px;

            color: #fff !important;

            display: flex;
            align-items: center;
            gap: 9px;

            letter-spacing: -.2px;
        }


        .brand-icon {
            width: 38px;
            height: 38px;

            border-radius: 11px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: rgba(255, 255, 255, .12);

            border: 1px solid rgba(255, 255, 255, .15);

            font-size: 19px;
        }


        .brand-text {
            line-height: 1.1;
        }


        .brand-subtitle {
            display: block;

            font-size: 9px;

            font-weight: 500;

            letter-spacing: 1px;

            text-transform: uppercase;

            color: rgba(255, 255, 255, .55);

            margin-top: 3px;
        }


        /* =====================================================
           NAVIGATION
        ===================================================== */

        .navbar-nav {
            gap: 4px;
        }


        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, .72) !important;

            font-size: 13px;

            font-weight: 600;

            padding: 9px 13px !important;

            border-radius: 9px;

            transition: all .2s ease;

            display: flex;
            align-items: center;
            gap: 7px;
        }


        .navbar-nav .nav-link:hover {
            color: #fff !important;

            background:
                rgba(255, 255, 255, .10);

            transform: translateY(-1px);
        }


        .navbar-nav .nav-link.active {
            color: #fff !important;

            background:
                rgba(255, 255, 255, .14);

            box-shadow:
                inset 0 0 0 1px rgba(255, 255, 255, .08);
        }


        .navbar-toggler {
            border: 1px solid rgba(255, 255, 255, .25);

            border-radius: 9px;

            padding: 7px 10px;
        }


        .navbar-toggler:focus {
            box-shadow:
                0 0 0 .2rem rgba(255, 255, 255, .12);
        }


        /* =====================================================
           MAIN CONTENT
        ===================================================== */

        .main-content {
            min-height: calc(100vh - 170px);

            padding-top: 30px;
            padding-bottom: 40px;
        }


        .content-container {
            max-width: 1400px;
        }


        /* =====================================================
           ALERTS
        ===================================================== */

        .modern-alert {
            border: 0;

            border-radius: 13px;

            padding: 14px 17px;

            box-shadow:
                0 5px 18px rgba(15, 23, 42, .06);

            font-size: 14px;

            font-weight: 500;
        }


        .alert-success {
            background: #ecfdf5;

            color: #047857;
        }


        .alert-danger {
            background: #fef2f2;

            color: #b91c1c;
        }


        .alert-warning {
            background: #fffbeb;

            color: #b45309;
        }


        .alert-info {
            background: #eff6ff;

            color: #1d4ed8;
        }


        /* =====================================================
           FOOTER
        ===================================================== */

        .main-footer {
            background: #fff;

            border-top: 1px solid var(--border);

            padding: 28px 0;

            margin-top: 20px;
        }


        .footer-content {
            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 20px;
        }


        .footer-brand {
            font-weight: 700;

            color: #334155;

            font-size: 14px;
        }


        .footer-text {
            color: #94a3b8;

            font-size: 12px;

            margin-top: 4px;
        }


        .footer-badge {
            display: inline-flex;

            align-items: center;

            gap: 6px;

            padding: 7px 11px;

            border-radius: 999px;

            background: #f1f5f9;

            color: #64748b;

            font-size: 11px;

            font-weight: 600;
        }


        /* =====================================================
           SCROLLBAR
        ===================================================== */

        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }


        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }


        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;

            border-radius: 10px;
        }


        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }


        /* =====================================================
           MOBILE
        ===================================================== */

        @media (max-width: 991px) {

            .navbar-collapse {
                margin-top: 14px;

                padding: 10px;

                border-radius: 13px;

                background:
                    rgba(255, 255, 255, .05);
            }


            .navbar-nav {
                gap: 3px;
            }


            .navbar-nav .nav-link {
                padding: 10px 12px !important;
            }

        }


        @media (max-width: 767px) {

            .main-content {
                padding-top: 20px;
            }


            .footer-content {
                flex-direction: column;

                text-align: center;
            }

        }
    </style>

    @stack('styles')

</head>


<body>


    {{-- ========================================================= --}}
    {{-- NAVBAR --}}
    {{-- ========================================================= --}}

    <nav class="navbar navbar-expand-lg main-navbar">

        <div class="container content-container">


            {{-- BRAND --}}
            <a
                class="navbar-brand"
                href="{{ route('posts.index') }}">

                <span class="brand-icon">
                    📝
                </span>

                <span class="brand-text">

                    UserStamps

                    <span class="brand-subtitle">
                        Management System
                    </span>

                </span>

            </a>


            {{-- MOBILE BUTTON --}}
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mainNavigation"
                aria-controls="mainNavigation"
                aria-expanded="false"
                aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

            </button>


            {{-- NAVIGATION --}}
            <div
                class="collapse navbar-collapse"
                id="mainNavigation">

                <ul class="navbar-nav ms-auto">


                    {{-- Dashboard --}}
                    <li class="nav-item">

                        <a
                            href="{{ route('dashboard') }}"
                            class="nav-link
                        {{ request()->routeIs('dashboard')
                            ? 'active'
                            : '' }}">

                            <i class="bi bi-grid-1x2-fill"></i>

                            Dashboard

                        </a>

                    </li>


                    {{-- Posts --}}
                    <li class="nav-item">

                        <a
                            href="{{ route('posts.index') }}"
                            class="nav-link
                        {{ request()->routeIs('posts.index')
                            ? 'active'
                            : '' }}">

                            <i class="bi bi-file-earmark-text-fill"></i>

                            Posts

                        </a>

                    </li>


                    {{-- Create Post --}}
                    <li class="nav-item">

                        <a
                            href="{{ route('posts.create') }}"
                            class="nav-link
                        {{ request()->routeIs('posts.create')
                            ? 'active'
                            : '' }}">

                            <i class="bi bi-plus-circle-fill"></i>

                            Create Post

                        </a>

                    </li>


                    {{-- Trashed --}}
                    <li class="nav-item">

                        <a
                            href="{{ route('posts.trashed') }}"
                            class="nav-link
                        {{ request()->routeIs('posts.trashed')
                            ? 'active'
                            : '' }}">

                            <i class="bi bi-trash3-fill"></i>

                            Trashed

                        </a>

                    </li>


                    {{-- Activity --}}
                    <li class="nav-item">

                        <a
                            href="{{ route('activity.history') }}"
                            class="nav-link
                        {{ request()->routeIs('activity.history')
                            ? 'active'
                            : '' }}">

                            <i class="bi bi-clock-history"></i>

                            Activity

                        </a>

                    </li>


                </ul>

            </div>

        </div>

    </nav>


    {{-- ========================================================= --}}
    {{-- MAIN CONTENT --}}
    {{-- ========================================================= --}}

    <main class="main-content">

        <div class="container content-container">


            {{-- SUCCESS MESSAGE --}}
            @if(session('success'))

            <div
                class="alert alert-success alert-dismissible fade show modern-alert"
                role="alert">

                <i class="bi bi-check-circle-fill me-2"></i>

                {{ session('success') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
                </button>

            </div>

            @endif


            {{-- ERROR MESSAGE --}}
            @if(session('error'))

            <div
                class="alert alert-danger alert-dismissible fade show modern-alert"
                role="alert">

                <i class="bi bi-exclamation-triangle-fill me-2"></i>

                {{ session('error') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
                </button>

            </div>

            @endif


            {{-- VALIDATION ERRORS --}}
            @if($errors->any())

            <div
                class="alert alert-danger modern-alert"
                role="alert">

                <div class="fw-bold mb-2">

                    <i class="bi bi-exclamation-circle-fill me-2"></i>

                    Please fix the following errors:

                </div>

                <ul class="mb-0">

                    @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                    @endforeach

                </ul>

            </div>

            @endif


            {{-- PAGE CONTENT --}}
            @yield('content')


        </div>

    </main>


    {{-- ========================================================= --}}
    {{-- FOOTER --}}
    {{-- ========================================================= --}}

    <footer class="main-footer">

        <div class="container content-container">

            <div class="footer-content">


                <div>

                    <div class="footer-brand">

                        📝 Laravel UserStamps Demo

                    </div>

                    <div class="footer-text">

                        Automatically track who created,
                        updated and deleted records.

                    </div>

                </div>


                <div>

                    <span class="footer-badge">

                        <i class="bi bi-shield-check"></i>

                        User Tracking Enabled

                    </span>

                </div>


            </div>

        </div>

    </footer>


    {{-- Bootstrap JS --}}
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>


    @stack('scripts')

</body>

</html>