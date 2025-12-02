<footer class="bottom-nav">
    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="fa-solid fa-house"></i><p>Beranda</p>
    </a>

    <a href="{{ route('menu.index') }}" class="{{ request()->routeIs('menu.*') ? 'active' : '' }}">
        <i class="fa-solid fa-utensils"></i><p>Menu</p>
    </a>

    <a href="{{ route('orders.index') }}" class="{{ request()->routeIs('orders.*') ? 'active' : '' }}">
        <i class="fa-solid fa-receipt"></i><p>Pesanan</p>
    </a>

    <a href="{{ route('sales.index') }}" class="{{ request()->routeIs('sales.*') ? 'active' : '' }}">
        <i class="fa-solid fa-chart-line"></i><p>Penjualan</p>
    </a>

    <a href="{{ route('profile.index') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">
        <i class="fa-solid fa-user"></i><p>Profile</p>
    </a>
</footer>
