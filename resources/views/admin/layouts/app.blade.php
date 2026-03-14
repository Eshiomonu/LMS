<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --sidebar-width: 250px;
            --sidebar-bg: #212529;
            --sidebar-hover: #343a40;
            --sidebar-active: #495057;
        }

        body {
            min-height: 100vh;
            overflow-x: hidden;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background-color: var(--sidebar-bg);
            overflow-y: auto;
            z-index: 1000;
        }

        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 1.25rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-section-title {
            padding: 0.75rem 1rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6c757d;
            margin-top: 0.5rem;
        }

        .sidebar-nav .nav-link {
            color: #adb5bd;
            padding: 0.75rem 1rem;
            margin: 0.125rem 0.5rem;
            border-radius: 0.375rem;
            transition: all 0.2s;
            display: flex;
            align-items: center;
        }

        .sidebar-nav .nav-link i {
            margin-right: 0.75rem;
            font-size: 1.1rem;
            width: 1.25rem;
        }

        .sidebar-nav .nav-link:hover {
            background-color: var(--sidebar-hover);
            color: #fff;
        }

        .sidebar-nav .nav-link.active {
            background-color: var(--sidebar-active);
            color: #fff;
        }

        .main-content {
            flex: 1;
            padding: 1.5rem;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }

            .main-wrapper {
                margin-left: 0;
            }

            .sidebar.show {
                margin-left: 0;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h5 class="text-white mb-0 fw-bold">
                <i class="bi bi-mortarboard-fill me-2"></i>
                AsproLearn Admin
            </h5>
        </div>
        
        <nav class="sidebar-nav">
            <ul class="nav flex-column">
                <!-- Dashboard -->
                @include('admin.partials.nav-item', [
                    'route' => 'admin.dashboard',
                    'icon' => 'speedometer2',
                    'label' => 'Dashboard',
                    'active' => request()->routeIs('admin.dashboard')
                ])

                <!-- Course Management Section -->
                <li class="nav-section-title">Course Management</li>
                
                @include('admin.partials.nav-item', [
                    'route' => 'admin.courses.index',
                    'icon' => 'book',
                    'label' => 'Courses',
                    'active' => request()->routeIs('admin.courses.*')
                ])

                @include('admin.partials.nav-item', [
                    'route' => 'admin.categories.index',
                    'icon' => 'grid',
                    'label' => 'Categories',
                    'active' => request()->routeIs('admin.categories.*')
                ])

                @include('admin.partials.nav-item', [
                    'route' => 'admin.lessons.index',
                    'icon' => 'journal-text',
                    'label' => 'Lessons',
                    'active' => request()->routeIs('admin.lessons.*')
                ])

                <!-- User Management Section -->
                <li class="nav-section-title">User Management</li>
                
                @include('admin.partials.nav-item', [
                    'route' => 'admin.users.index',
                    'icon' => 'people',
                    'label' => 'Users',
                    'active' => request()->routeIs('admin.users.*')
                ])

                @include('admin.partials.nav-item', [
                    'route' => 'admin.instructors.index',
                    'icon' => 'person-badge',
                    'label' => 'Instructors',
                    'active' => request()->routeIs('admin.instructors.*')
                ])

                @include('admin.partials.nav-item', [
                    'route' => 'admin.roles.index',
                    'icon' => 'shield-check',
                    'label' => 'Roles & Permissions',
                    'active' => request()->routeIs('admin.roles.*')
                ])

                <!-- Settings Section -->
                <li class="nav-section-title">Settings</li>
                
                @include('admin.partials.nav-item', [
                    'route' => 'admin.settings.general',
                    'icon' => 'gear',
                    'label' => 'General Settings',
                    'active' => request()->routeIs('admin.settings.general')
                ])

                @include('admin.partials.nav-item', [
                    'route' => 'admin.settings.email',
                    'icon' => 'envelope',
                    'label' => 'Email Configuration',
                    'active' => request()->routeIs('admin.settings.email')
                ])

                @include('admin.partials.nav-item', [
                    'route' => 'admin.settings.payment',
                    'icon' => 'credit-card',
                    'label' => 'Payment Settings',
                    'active' => request()->routeIs('admin.settings.payment')
                ])
            </ul>
        </nav>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="main-wrapper">
        <!-- Header -->
        <header class="bg-white shadow-sm border-bottom">
            <div class="container-fluid py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0 fw-bold">@yield('header-title', 'Dashboard')</h4>
                    </div>
                    <div class="header-actions">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-2"></i>
                                {{ Auth::user()->name ?? 'Admin' }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                        <i class="bi bi-person me-2"></i>Profile
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        @include('admin.partials.flash-messages')

        <!-- Page Content -->
        <main class="main-content">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-top py-3 mt-auto">
            <div class="container-fluid">
                <div class="text-center text-muted">
                    &copy; {{ date('Y') }} ASPRO LEARN Admin Panel. All rights reserved.
                </div>
            </div>
        </footer>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
