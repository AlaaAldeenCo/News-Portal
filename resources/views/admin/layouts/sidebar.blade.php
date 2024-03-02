<div class="navbar-bg"></div>
@include('admin.layouts.navbar')
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">{{ __('Stisla') }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">{{ __('St') }}</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">{{ __('Dashboard') }}</li>
            <li class="active">
                <a href="#" class="nav-link "><i class="fas fa-fire"></i><span>{{ __('Dashboard') }}</span></a>

            </li>
            <li class="menu-header">{{ __('Starter') }}</li>
            <li class="{{ setSidebarActive(['admin.category.index']) }}"><a class="nav-link"
                    href="{{ route('admin.category.index') }}"><i class="far fa-square"></i>
                    <span>{{ __('Category') }}</span></a></li>

            <li class="dropdown {{ setSidebarActive(['admin.news.*', 'admin.pending.news']) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                    <span>{{ __('News') }}</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setSidebarActive(['admin.news.*']) }}"><a class="nav-link"
                            href="{{ route('admin.news.index') }}">{{ __('All News') }}</a></li>
                    <li class="{{ setSidebarActive(['admin.pending.news']) }}"><a class="nav-link"
                            href="{{ route('admin.pending.news') }}">{{ __('All Pending News') }}</a></li>
                </ul>
            </li>

            <li class="dropdown {{ setSidebarActive(['admin.about.index', 'admin.contact.index']) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                    <span>{{ __('Pages') }}</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setSidebarActive(['admin.about.index']) }}"><a class="nav-link"
                            href="{{ route('admin.about.index') }}">{{ __('About Page') }}</a></li>
                    <li class="{{ setSidebarActive(['admin.contact.index']) }}"><a class="nav-link"
                            href="{{ route('admin.contact.index') }}">{{ __('Contact Page') }}</a></li>
                </ul>
            </li>


            <li
                class="{{ setSidebarActive(['admin.social-count.*', 'admin.contact-message.*', 'admin.social-count.index']) }}">
                <a class="nav-link" href="{{ route('admin.social-count.index') }}"><i class="far fa-square"></i>
                    <span>{{ __('Social Count') }}</span></a></li>
            <li class="{{ setSidebarActive(['admin.contact-message.index']) }}"><a class="nav-link"
                    href="{{ route('admin.contact-message.index') }}"><i class="far fa-square"></i>
                    <span>{{ __('Contact Messages') }}</span>
                    @if ($unreadMessages > 0)
                        <i class="badge bg-danger" style="color: #fff">{{ $unreadMessages }}</i>
                    @endif
                </a></li>
            <li class="{{ setSidebarActive(['admin.home-section-setting.index']) }}"><a class="nav-link"
                    href="{{ route('admin.home-section-setting.index') }}"><i class="far fa-square"></i>
                    <span>{{ __('Home Section Setting') }}</span></a></li>
            <li class="{{ setSidebarActive(['admin.language.*', 'admin.language.index']) }}"><a class="nav-link"
                    href="{{ route('admin.language.index') }}"><i class="far fa-square"></i>
                    <span>{{ __('Language') }}</span></a></li>
            <li class="{{ setSidebarActive(['admin.subscribers.*', 'admin.subscribers.index']) }}"><a class="nav-link"
                    href="{{ route('admin.subscribers.index') }}"><i class="far fa-square"></i>
                    <span>{{ __('Subscribers') }}</span></a></li>

            <li
                class="dropdown {{ setSidebarActive([
                    'admin.social-link.*',
                    'admin.footer-info.*',
                    'admin.footer-grid-one.*',
                    'admin.footer-grid-two.*',
                    'admin.footer-grid-three.*',
                ]) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                    <span>{{ __('Footer Setting') }}</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setSidebarActive(['admin.social-link.*']) }}"><a class="nav-link"
                            href="{{ route('admin.social-link.index') }}">{{ __('Social Links') }}</a></li>
                    <li class="{{ setSidebarActive(['admin.footer-info.*']) }}"><a class="nav-link"
                            href="{{ route('admin.footer-info.index') }}">{{ __('Footer Info') }}</a></li>
                    <li class="{{ setSidebarActive(['admin.footer-grid-one.*']) }}"><a class="nav-link"
                            href="{{ route('admin.footer-grid-one.index') }}">{{ __('Footer Grid One') }}</a></li>
                    <li class="{{ setSidebarActive(['admin.footer-grid-two.*']) }}"><a class="nav-link"
                            href="{{ route('admin.footer-grid-two.index') }}">{{ __('Footer Grid Two') }}</a></li>
                    <li class="{{ setSidebarActive(['admin.footer-grid-three.*']) }}"><a class="nav-link"
                            href="{{ route('admin.footer-grid-three.index') }}">{{ __('Footer Grid Three') }}</a></li>
                </ul>
            </li>

            <li class="dropdown {{ setSidebarActive(['admin.role-users.*', 'admin.role.*']) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                    <span>{{ __('Access Management') }}</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ setSidebarActive(['admin.role-users.*']) }}"><a class="nav-link"
                            href="{{ route('admin.role-users.index') }}">{{ __('Users Roles') }}</a></li>
                    <li class="{{ setSidebarActive(['admin.role.*']) }}"><a class="nav-link"
                            href="{{ route('admin.role.index') }}">{{ __('Roles and Permissions') }}</a></li>
                </ul>
            </li>

            <li class="{{ setSidebarActive(['admin.setting.*', 'admin.setting.index']) }}"><a class="nav-link"
                    href="{{ route('admin.setting.index') }}"><i class="far fa-square"></i>
                    <span>{{ __('Settings') }}</span></a></li>
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
