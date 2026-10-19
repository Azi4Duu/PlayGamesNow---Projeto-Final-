<aside class="admin-sidebar">
    <h4>Admin</h4>
    <a href="{{route('admin.dashboard.show')}}" class="{{ request()->routeIs('admin.dashboard.show') ? 'active' : '' }}">Dashboard</a>
    <a href="{{route('admin.users.index')}}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Users</a>
    <a href="{{route('admin.games.index')}}" class="{{ request()->routeIs('admin.games.*') ? 'active' : '' }}">Games</a>
    <a href="{{route('admin.platforms.index')}}" class="{{ request()->routeIs('admin.platforms.*') ? 'active' : '' }}">Platforms</a>
    <a href="{{route('admin.publishers.index')}}" class="{{ request()->routeIs('admin.publishers.*') ? 'active' : '' }}">Publishers</a>
    <a href="{{route('admin.categories.index')}}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">Categories</a>
    <a href="{{route('admin.coupons.index')}}" class="{{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">Coupons</a>
    <a href="{{route('admin.keys.index')}}" class="{{ request()->routeIs('admin.keys.*') ? 'active' : '' }}">Game Keys</a>
    <a href="{{route('admin.sales.index')}}" class="{{ request()->routeIs('admin.sales.*') ? 'active' : '' }}">Sales</a>
</aside>
