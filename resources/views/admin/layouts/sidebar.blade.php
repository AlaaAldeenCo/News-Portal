<div class="navbar-bg"></div>
@include('admin.layouts.navbar')
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Stisla</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="active">
                <a href="#" class="nav-link "><i class="fas fa-fire"></i><span>Dashboard</span></a>

            </li>
            <li class="menu-header">Starter</li>
            <li><a class="nav-link" href="{{route('admin.category.index')}}"><i class="far fa-square"></i> <span>Category</span></a></li>

            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                    <span>News</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{route('admin.news.index')}}">All News</a></li>
                    <li><a class="nav-link" href="{{route('admin.pending.news')}}">All Pending News</a></li>
                </ul>


            <li><a class="nav-link" href="{{route('admin.home-section-setting.index')}}"><i class="far fa-square"></i> <span>Home Section Setting</span></a></li>
            <li><a class="nav-link" href="{{route('admin.language.index')}}"><i class="far fa-square"></i> <span>Language</span></a></li>
            {{-- <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                    <span>Layout</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="layout-default.html">Default Layout</a></li>
                    <li><a class="nav-link" href="layout-transparent.html">Transparent Sidebar</a></li>
                    <li><a class="nav-link" href="layout-top-navigation.html">Top Navigation</a></li>
                </ul> --}}
            </li>

        </ul>

    </aside>
</div>
