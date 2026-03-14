{{-- 
    Reusable Navigation Item Component
    
    Usage:
    @include('admin.partials.nav-item', [
        'route' => 'admin.dashboard',
        'icon' => 'speedometer2',
        'label' => 'Dashboard',
        'active' => request()->routeIs('admin.dashboard')
    ])
--}}

<li class="nav-item">
    <a href="{{ route($route) }}" 
       class="nav-link {{ $active ? 'active' : '' }}"
       aria-current="{{ $active ? 'page' : 'false' }}">
        <i class="bi bi-{{ $icon }}"></i>
        <span>{{ $label }}</span>
    </a>
</li>
