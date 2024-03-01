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
            <li class="menu-header">{{__('Dashboard')}}</li>
            <li class="active">
                <a href="#" class="nav-link "><i class="fas fa-fire"></i><span>{{__('Dashboard')}}</span></a>

            </li>
            <li class="menu-header">Starter</li>
            <li><a class="nav-link" href="{{ route('admin.category.index') }}"><i class="far fa-square"></i>
                <span>{{__('Category')}}</span></a></li>

            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                    <span>{{__('News')}}</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('admin.news.index') }}">{{__('All News')}}</a></li>
                    <li><a class="nav-link" href="{{ route('admin.pending.news') }}">{{__('All Pending News')}}</a></li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                    <span>{{__('Pages')}}</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('admin.about.index') }}">{{__('About Page')}}</a></li>
                    <li><a class="nav-link" href="{{ route('admin.contact.index') }}">{{__('Contact Page')}}</a></li>
                </ul>
            </li>


            <li><a class="nav-link" href="{{ route('admin.social-count.index') }}"><i class="far fa-square"></i>
                    <span>{{__('Social Count')}}</span></a></li>
            <li><a class="nav-link" href="{{ route('admin.home-section-setting.index') }}"><i class="far fa-square"></i>
                    <span>{{__('Home Section Setting')}}</span></a></li>
            <li><a class="nav-link" href="{{ route('admin.language.index') }}"><i class="far fa-square"></i>
                    <span>{{__('Language')}}</span></a></li>
            <li><a class="nav-link" href="{{ route('admin.subscribers.index') }}"><i class="far fa-square"></i>
                    <span>{{__('Subscribers')}}</span></a></li>

                    <li class="dropdown">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                            <span>{{__('Footer Setting')}}</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="{{ route('admin.social-link.index') }}">{{__('Social Links')}}</a></li>
                            <li><a class="nav-link" href="{{ route('admin.footer-info.index') }}">{{__('Footer Info')}}</a></li>
                            <li><a class="nav-link" href="{{ route('admin.footer-grid-one.index') }}">{{__('Footer Grid One')}}</a></li>
                            <li><a class="nav-link" href="{{ route('admin.footer-grid-two.index') }}">{{__('Footer Grid Two')}}</a></li>
                            <li><a class="nav-link" href="{{ route('admin.footer-grid-three.index') }}">{{__('Footer Grid Three')}}</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                            <span>{{__('Access Management')}}</span></a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="{{ route('admin.role-users.index') }}">{{__('Users Roles')}}</a></li>
                            <li><a class="nav-link" href="{{ route('admin.role.index') }}">{{__('Roles and Permissions')}}</a></li>
                        </ul>
                    </li>
            {{-- <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                    <span>Layout</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="layout-default.html">Default Layout</a></li>
                    <li><a class="nav-link" href="layout-transparent.html">Transparent Sidebar</a></li>
                    <li><a class="nav-link" href="layout-top-navigation.html">Top Navigation</a></li>
                </ul> --}}
            {{-- </li> --}}

        </ul>

    </aside>
</div>
